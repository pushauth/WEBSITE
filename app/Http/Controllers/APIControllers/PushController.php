<?php

namespace PushAuth\Http\Controllers\APIControllers;

use Carbon\Carbon;
use Dingo\Api\Exception\ResourceException;
use Illuminate\Encryption\BaseEncrypter;
use Illuminate\Encryption\Encrypter;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use Mail;
use phpDocumentor\Reflection\Types\Array_;
use PushAuth\Http\Requests;
use PushAuth\Http\Controllers\Controller;
use PushAuth\Jobs\SendPush;
use PushAuth\Jobs\WebHook;
use PushAuth\PushRequest;
use PushAuth\PushRoutes;
use PushAuth\User;
use PushAuth\UserApp;
use PushAuth\UserDevices;
use PushAuth\UserMsgLog;
use Redis;
use Validator;
use QrCode;

class PushController extends Controller
{

    public function showErrorsFirst($errors)
    {

        return $errors[0];

    }


    private function decodeData($str)
    {


        // BASE64.hmac.base64(SomeKeyWithAnswer)

        $data = $str;
        $data = explode('.', $data);
        $keyWithAnswer = explode('.', base64_decode($data[2]));
        $hmac = $data[1];
        $msg = base64_decode($data[0]);

        //$decryptData = openssl_decrypt($msg, 'aes-256-cbc', $privateKey, 0, $iv);

        return ['data'   => json_decode($msg, true),
                'hmac'   => $hmac,
                'key'    => $keyWithAnswer[0],
                'answer' => (boolean)$keyWithAnswer[1]];


    }

    private function encodeData($str, $pk)
    {

        $str = base64_encode(json_encode($str));

        $hmac = base64_encode(hash_hmac('sha256', $str, $pk, true));

        return $str . '.' . $hmac;


    }


    public function index(Request $request)
    {
        $json = $request->json()->all();


        $validator = Validator::make($json, [
            'pk'   => 'required',
            'data' => 'required',
        ]);

        if ($validator->fails()) {
            //throw new ResourceException('Validating error.', $validator->errors());
            throw new ResourceException('Validating error: ' . $this->showErrorsFirst($validator->errors()->all()), $validator->errors());

            // return response()->json(['error_message' => $validator->errors()], 400);
        }

        if (UserDevices::where('public_key', $json['pk'])->exists() == false) {
            throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException('Device not found.');
        }

            $device = UserDevices::where('public_key', $json['pk'])->first();

            if ($device->user->status == 'disable') {
                throw new \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException('User is disabled.');
            }

            if ($device->status == 'disable') {
                throw new \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException('Device is disabled.');
            }


            $mobileData = explode('.', $json['data']);
            $mobileClearData = $mobileData[0];
            $mobileDataString = json_decode(base64_decode($mobileData[0]), true);
            $clientSign = $mobileData[1];

            $serverSign = base64_encode(hash_hmac('sha256', $mobileClearData, $device->private_key, true));

            if ($clientSign != $serverSign) {
                throw new \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException('Your HMAC sign is not correct!');
            }



        $prArr = [];



            //Code here
            if (PushRequest::where('device_id', $device->id)
                    ->where('response_code', Null)
                    ->whereIn('mode', ['push', 'code'])
                    ->where('created_at', '>=', Carbon::now()->subSeconds(30)->toDateTimeString())
                    ->count() > 0
            ) {

                $pushRequest = PushRequest::where('device_id', $device->id)
                    ->where('response_code', Null)
                    ->whereIn('mode', ['push', 'code'])
                    ->where('created_at', '>=', Carbon::now()->subSeconds(45)->toDateTimeString())
                    ->orderBy('id', 'desc')
                    ->get();




                foreach ($pushRequest as $pr) {

                    /*if($pr->response_code == Null) {

                    }*/

                    array_push($prArr, [
                        'req_hash' => $pr->hash,
                        'mode'     => $pr->mode,
                        'code'     => $pr->code,
                        'app_name' => $pr->app->name,
                    ]);


                    $pr->update([
                        'response_code' => '200',
                        'response_dt'   => Carbon::now(),
                    ]);


                }


            }



            $pushRoutes = PushRoutes::where('device_id', $device->id)
                                    ->where('status','sended')
                                    ->where('response_code', Null)
                                    ->where('sended_dt', '>=', Carbon::now()->subSeconds(45)->toDateTimeString())
                                    ->get();


        foreach ($pushRoutes as $pushRoute) {
            array_push($prArr, [
                'req_hash' => $pushRoute->pushRequest->hash,
                'mode'     => 'push',
                'code'     => Null,
                'app_name' => $pushRoute->pushRequest->app->name,
            ]);

            $pushRoute->update([
                'response_code' =>'200',
                'response_dt'   => Carbon::now(),
            ]);



        }









        $data = [
            'total' => (int)count($prArr),
            'index' => $prArr,
        ];




            $encData = $this->encodeData($data, $device->private_key);
            //$encData=$data;

            $resData = [
                'data' => $encData,

            ];

            return response()->json($resData, 200);



    }



    protected function modeRouteOrder(PushRequest $pushRequest, UserDevices $device, $answer){

        $pushRequest->routes()->where('device_id', $device->id)->update([
            'status'    => 'success',
            'answer'    => $answer,
            'answer_dt' => Carbon::now(),
        ]);

        $clientsArr = $pushRequest->routes->unique('client_id')->lists('client_id')->toArray();
        //$answer = null;

        $answersCount = 0;
        $answersTrueCount=0;
        $answersFalseCount=0;
        foreach ($clientsArr as $c) {
            if ($pushRequest->routes()->where('client_id', $c)->whereIn('answer', ['true', 'false'])->count() > 0) {
                $answersCount++;
            }
            if ($pushRequest->routes()->where('client_id', $c)->where('answer', 'true')->count() > 0) {
                $answersTrueCount++;
            }
            if ($pushRequest->routes()->where('client_id', $c)->where('answer', 'false')->count() > 0) {
                $answersFalseCount++;
            }

        }


        $totalRoutes = $pushRequest->routes()->count();
        $totalRoutesGroup = $pushRequest->routes()->groupBy('order')->count();


        //For Order answer
        if ($totalRoutes != $totalRoutesGroup) {

            Log::debug('Fired order routes');


            //If not all anwers
            if (count($clientsArr) != $answersCount) {


                if ($answer == 'false') {
                    Log::debug('Answer false');

                    Redis::set($pushRequest->uniq_request_id, 'false');
                    Redis::expire($pushRequest->uniq_request_id, 30);


                    $pushRequest->update([
                        'answer'           => 'false',
                        'response_dt'      => Carbon::now(),
                        'response_code'    => 200,
                        'response_message' => 'One client of order list set NO answer.',
                    ]);

                    $resData = [
                        'message' => 'Success answer received!',
                    ];


                    $job = (new WebHook($pushRequest->uniq_request_id, 'push'));
                    $this->dispatch($job);



                    return response()->json($resData, 200);


                }


                Log::debug('Fired that not all are answered');

                $clientID = PushRoutes::where('req_id', $pushRequest->id)
                    ->where('status', 'wait')
                    ->orderBy('order', 'asc')
                    ->first()->client_id;

                //$nextPushRoute->first()

                $nextPushRoute = PushRoutes::where('req_id', $pushRequest->id)
                    ->where('status', 'wait')
                    ->where('client_id', $clientID)
                    ->get();


                foreach ($nextPushRoute as $pushRoute) {

                   // Log::debug('Fired next route '. print_r($pushRoute,true));

                    $pushRoute->update([
                        'status'    => 'sended',
                        'sended_dt' => Carbon::now(),
                    ]);
                    $encodePush = [
                        'req_hash' => $pushRequest->hash,
                        'mode'     => 'push',
                        'code'     => Null,
                        'app_name' => $pushRequest->app->name,

                    ];

                    $this->dispatch(new SendPush($pushRoute->device->token, $pushRoute->device->os, $encodePush));


                }
            }


        }

        //All answers
        elseif ($totalRoutes == $totalRoutesGroup) {
            //If all users answered
            //Log::debug('Fired all routes');

        }



        //If all are answered:
        if (count($clientsArr) == $answersCount) {


            if ($answersCount == $answersTrueCount) {
                $answer = 'true';
            }
            else {
                $answer = 'false';
            }




            Redis::set($pushRequest->uniq_request_id, $answer);
            Redis::expire($pushRequest->uniq_request_id, 30);


            $pushRequest->update([
                'answer'           => $answer,
                'response_dt'      => Carbon::now(),
                'response_code'    => 200,
                'response_message' => 'Success all answers received',
            ]);

            $resData = [
                'message' => 'Success answer received!',
            ];


            $job = (new WebHook($pushRequest->uniq_request_id, 'push'));
            $this->dispatch($job);


            //$job = (new WebHook($pushRequest, 'push'));
            //$this->dispatch($job);


            return response()->json($resData, 200);

        }





        $resData = [
            'message' => 'Success answer received!',
        ];

        return response()->json($resData, 200);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function storePushAnswer(Request $request)
    {
        //

        $json = $request->json()->all();


        $validator = Validator::make($json, [
            'pk'   => 'required',
            'data' => 'required',
        ]);

        if ($validator->fails()) {
            throw new ResourceException('Validating error: ' . $this->showErrorsFirst($validator->errors()->all()), $validator->errors());

//            throw new ResourceException('Validating error.', $validator->errors());
            // return response()->json(['error_message' => $validator->errors()], 400);
        }

        if (UserDevices::where('public_key', $json['pk'])->exists() == false) {
            throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException('Device not found.');
        }
        $device = UserDevices::where('public_key', $json['pk'])->first();

        if ($device->user->status == 'disable') {
            throw new \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException('User is disabled.');
        }

        if ($device->status == 'disable') {
            throw new \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException('Device is disabled.');
        }


        $mobileData = explode('.', $json['data']);
        $mobileClearData = $mobileData[0];
        $mobileDataString = json_decode(base64_decode($mobileData[0]), true);
        $clientSign = $mobileData[1];
        //$mobileDataHmac = $mobileData[2];


        $serverSign = base64_encode(hash_hmac('sha256', $mobileClearData, $device->private_key, true));


        if ($clientSign != $serverSign) {
            throw new \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException('Your HMAC sign is not correct!');
        }


        if ($mobileDataString['answer']) {
            $answer = 'true';
        } else {
            $answer = 'false';
        }

        //Log::debug('Answer: '.base64_decode($mobileData[0]));
        /*
         * $requestHash
         * $answer
         *
         */
        if (PushRequest::where('hash', $mobileDataString['hash'])->where('answer', Null)->exists() == false) {
            throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException('Push request not found.');
        }


        $pushRequest = PushRequest::where('hash', $mobileDataString['hash'])->where('answer', Null)->first();

        //$answer = $normData['answer'];
        if ($pushRequest->mode == 'code') {
            $answer = Null;
        }

        if ($pushRequest->mode == 'route') {


            $pushRequest->routes()->where('device_id', $device->id)->update([
                'status'    => 'success',
                'answer'    => $answer,
                'answer_dt' => Carbon::now(),
            ]);

            $clientsArr = $pushRequest->routes->unique('client_id')->lists('client_id')->toArray();
            //$answer = null;

            $answersCount = 0;
            $answersTrueCount=0;
            $answersFalseCount=0;
            foreach ($clientsArr as $c) {
                if ($pushRequest->routes()->where('client_id', $c)->whereIn('answer', ['true', 'false'])->count() > 0) {
                    $answersCount++;
                }
                if ($pushRequest->routes()->where('client_id', $c)->where('answer', 'true')->count() > 0) {
                    $answersTrueCount++;
                }
                if ($pushRequest->routes()->where('client_id', $c)->where('answer', 'false')->count() > 0) {
                    $answersFalseCount++;
                }

            }


            $totalRoutes = $pushRequest->routes()->count();
            $totalRoutesGroup = $pushRequest->routes()->groupBy('order')->count();


            //For Order answer
            if ($totalRoutes != $totalRoutesGroup) {

//Log::debug('Fired order routes');


                //If not all anwers
                if (count($clientsArr) != $answersCount) {


                    if ($answer == 'false') {
                        Log::debug('Answer false');

                        Redis::set($pushRequest->uniq_request_id, 'false');
                        Redis::expire($pushRequest->uniq_request_id, 30);


                        $pushRequest->update([
                            'answer'           => 'false',
                            'response_dt'      => Carbon::now(),
                            'response_code'    => 200,
                            'response_message' => 'One client of order list set NO answer.',
                        ]);

                        $resData = [
                            'message' => 'Success answer received!',
                        ];


                        $job = (new WebHook($pushRequest->uniq_request_id, 'push'));
                        $this->dispatch($job);



                        return response()->json($resData, 200);


                    }


                    //Log::debug('Fired that not all are answered');

                    $clientID = PushRoutes::where('req_id', $pushRequest->id)
                        ->where('status', 'wait')
                        ->orderBy('order', 'asc')
                        ->first()->client_id;

                    //$nextPushRoute->first()

                    $nextPushRoute = PushRoutes::where('req_id', $pushRequest->id)
                        ->where('status', 'wait')
                        ->where('client_id', $clientID)
                        ->get();


                    foreach ($nextPushRoute as $pushRoute) {

                        Log::debug('Fired next route '. print_r($pushRoute,true));

                        $pushRoute->update([
                            'status'    => 'sended',
                            'sended_dt' => Carbon::now(),
                        ]);
                        $encodePush = [
                            'req_hash' => $pushRequest->hash,
                            'mode'     => 'push',
                            'code'     => Null,
                            'app_name' => $pushRequest->app->name,

                        ];

                        $this->dispatch(new SendPush($pushRoute->device->token, $pushRoute->device->os, $encodePush));


                    }
                }


            }

            //All answers
            elseif ($totalRoutes == $totalRoutesGroup) {
                //If all users answered
                Log::debug('Fired all routes');

            }



            //If all are answered:
            if (count($clientsArr) == $answersCount) {


                if ($answersCount == $answersTrueCount) {
                    $answer = 'true';
                }
                else {
                    $answer = 'false';
                }




                Redis::set($pushRequest->uniq_request_id, $answer);
                Redis::expire($pushRequest->uniq_request_id, 30);


                $pushRequest->update([
                    'answer'           => $answer,
                    'response_dt'      => Carbon::now(),
                    'response_code'    => 200,
                    'response_message' => 'Success all answers received',
                ]);

                $resData = [
                    'message' => 'Success answer received!',
                ];


                $job = (new WebHook($pushRequest->uniq_request_id, 'push'));
                $this->dispatch($job);


                //$job = (new WebHook($pushRequest, 'push'));
                //$this->dispatch($job);


                return response()->json($resData, 200);

            }





            $resData = [
                'message' => 'Success answer received!',
            ];

            return response()->json($resData, 200);


        }


        $pushRequest->update([
            'answer'           => $answer,
            'response_dt'      => Carbon::now(),
            'response_code'    => 200,
            'response_message' => 'Success answer received',
        ]);


        if (PushRequest::where('uniq_request_id', $pushRequest->uniq_request_id)
                ->whereIn('answer', ['true', 'false'])
                ->count() == 1
        ) {

            Redis::set($pushRequest->uniq_request_id, $answer);
            Redis::expire($pushRequest->uniq_request_id, 30);


            $resData = [
                'message' => 'Success answer received!',
            ];


            $job = (new WebHook($pushRequest->uniq_request_id, 'push'));
            $this->dispatch($job);


            return response()->json($resData, 200);


        } else {
            $resData = [
                'message' => 'Success answer received!',
            ];

            return response()->json($resData, 200);

        }


    }


    public function limitPushes(User $user)
    {

        $limits = $user->plan->limits;

        $limitDay = $limits->where('key', 'pushes')->where('period', 'day')->first()->value;
        $limitMonth = $limits->where('key', 'pushes')->where('period', 'month')->first()->value;

        $appArr = $user->app->lists('id')->toArray();

        $pushesDay = PushRequest::whereIn('app_id', $appArr)
            ->whereIn('mode', ['code', 'push', 'route'])
            ->where('test', 'false')
            ->where('created_at', '>=', Carbon::now()
                ->subDay())->count();

        $pushesMonth = PushRequest::whereIn('app_id', $appArr)
            ->whereIn('mode', ['code', 'push', 'route'])
            ->where('test', 'false')
            ->where('created_at', '>=', Carbon::now()
                ->subMonth())->count();


        if ($pushesDay > $limitDay) {


            if (UserMsgLog::where('user_id', $user->id)
                    ->where('msg_pushlimit_dt', '>=', Carbon::now()
                        ->subDay())->exists() == false
            ) {

                $user->msgLogLast()->update([
                    'msg_pushlimit_dt' => Carbon::now(),
                ]);

                $dataMail = [
                    'url'  => route('profile.price'),
                    'body' => 'Dear customer, your free price plan reached push hour limit. Please upgrade your plan for use more hour pushes: ' . route('profile.price'),
                ];

                Mail::queue(['text' => 'emails.information.notify'], $dataMail, function ($message) use ($user) {
                    $message->from(env('MAIL_ADDRESS'), 'PushAuth');
                    $message->subject('PushAuth PricePlan limits');
                    $message->to($user->email);
                });
                $user->notifications()->create([
                    'subject' => 'Price Plan Limits!',
                    'body'    => 'Dear customer, your free price plan reached push hour limit. Please upgrade your plan for use more hour pushes: <a href=\'' . route('profile.price') . '\'>Change Price Plan</a>',
                    'urlhash' => str_random(32),
                ]);


            }


            if ($pushesDay > ($limitDay + 25)) {
                throw new \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException('Pushes day limit: ' . $limitDay . '. Upgrade your price plan for more pushes or wait some time.');
            }
        }

        if ($pushesMonth > $limitMonth) {

            if (UserMsgLog::where('user_id', $user->id)
                    ->where('msg_pushlimit_dt', '>=', Carbon::now()
                        ->subDay())->exists() == false
            ) {

                $user->msgLogLast()->update([
                    'msg_pushlimit_dt' => Carbon::now(),
                ]);

                $dataMail = [
                    'url'  => route('profile.price'),
                    'body' => 'Dear customer, your free price plan reached push month limit. Please upgrade your plan for use more month pushes: ' . route('profile.price'),
                ];

                Mail::queue(['text' => 'emails.information.notify'], $dataMail, function ($message) use ($user) {
                    $message->from(env('MAIL_ADDRESS'), 'PushAuth');
                    $message->subject('PushAuth PricePlan limits');
                    $message->to($user->email);
                });
                $user->notifications()->create([
                    'subject' => 'Price Plan Limits!',
                    'body'    => 'Dear customer, your free price plan reached push month limit. Please upgrade your plan for use more month pushes: <a href=\'' . route('profile.price') . '\'>Change Price Plan</a>',
                    'urlhash' => str_random(32),
                ]);


            }


            if ($pushesMonth > ($limitMonth + 25)) {
                throw new \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException('Pushes month limit: ' . $limitMonth . '. Upgrade your price plan for more pushes or wait some time.');
            }
        }


    }

    public function limitClients(User $user)
    {

        $limits = $user->plan->limits;

        $limitClients = $limits->where('key', 'users')->first()->value;

        $appArr = $user->app->lists('id')->toArray();

        $pr = PushRequest::whereIn('app_id', $appArr)->where('test', 'false')->get();

        $devID = $pr->lists('device_id')->toArray();
        $devID = array_unique($devID);

        $prArr = $pr->lists('id')->toArray();
        $prArr = array_unique($prArr);

        $clientsRoutes = PushRoutes::whereIn('req_id', $prArr)->lists('client_id')->toArray();
        $clientsRoutes = array_unique($clientsRoutes);

        $clients = UserDevices::whereIn('id', $devID)->lists('user_id')->toArray();
        $clients = array_merge($clients, $clientsRoutes);
        $clients = array_filter($clients, function ($var) {
            return !is_null($var);
        });

        $clientCount = count(array_unique($clients));


        //Log::debug('Limit Clients:'. $clientCount. ' / '. $limitClients);


        if ($clientCount > $limitClients) {

            if (UserMsgLog::where('user_id', $user->id)
                    ->where('msg_userlimit_dt', '>=', Carbon::now()
                        ->subDay())->exists() == false
            ) {

                $user->msgLogLast()->update([
                    'msg_userlimit_dt' => Carbon::now(),
                ]);

                $dataMail = [
                    'url'  => route('profile.price'),
                    'body' => 'Dear customer, your free price plan reached clients limit. Please upgrade your plan for use more clients: ' . route('profile.price'),
                ];

                Mail::queue(['text' => 'emails.information.notify'], $dataMail, function ($message) use ($user) {
                    $message->from(env('MAIL_ADDRESS'), 'PushAuth');
                    $message->subject('PushAuth PricePlan limits');
                    $message->to($user->email);
                });
                $user->notifications()->create([
                    'subject' => 'Price Plan Limits!',
                    'body'    => 'Dear customer, your free price plan reached clients limit. Please upgrade your plan for use more clients: <a href=\'' . route('profile.price') . '\'>Change Price Plan</a>',
                    'urlhash' => str_random(32),
                ]);


            }

            if ($clientCount > ($limitClients + 5)) {
                throw new \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException('Clients limit: ' . $limitClients . '. Upgrade your price plan for send pushes to more clients.');
            }

        }


    }

    public function limitDevices(User $user)
    {

        $limits = $user->plan->limits;

        $limitDevices = $limits->where('key', 'devices')->first()->value;

        $appArr = $user->app->lists('id')->toArray();
        $pr = PushRequest::whereIn('app_id', $appArr)->where('test', 'false')->get();

        $prArr = $pr->lists('id')->toArray();
        $prArr = array_unique($prArr);

        $devRoutes = PushRoutes::whereIn('req_id', $prArr)->lists('device_id')->toArray();
        $devRoutes = array_unique($devRoutes);

        $devID = $pr->lists('device_id')->toArray();
        $devID = array_merge($devRoutes, $devID);

        $devID = array_unique($devID);
        $devID = array_filter($devID, function ($var) {
            return !is_null($var);
        });

        $deviceCount = count($devID);


        //Log::debug('Limit Devices:'. $deviceCount. ' / '. $limitDevices);


        if ($deviceCount > $limitDevices) {

            if (UserMsgLog::where('user_id', $user->id)
                    ->where('msg_devicelimit_dt', '>=', Carbon::now()
                        ->subDay())->exists() == false
            ) {

                $user->msgLogLast()->update([
                    'msg_devicelimit_dt' => Carbon::now(),
                ]);

                $dataMail = [
                    'url'  => route('profile.price'),
                    'body' => 'Dear customer, your free price plan reached device limit. Please upgrade your plan for use more devices: ' . route('profile.price'),
                ];

                Mail::queue(['text' => 'emails.information.notify'], $dataMail, function ($message) use ($user) {
                    $message->from(env('MAIL_ADDRESS'), 'PushAuth');
                    $message->subject('PushAuth PricePlan limits');
                    $message->to($user->email);
                });
                $user->notifications()->create([
                    'subject' => 'Price Plan Limits!',
                    'body'    => 'Dear customer, your free price plan reached device limit. Please upgrade your plan for use more devices: <a href=\'' . route('profile.price') . '\'>Change Price Plan</a>',
                    'urlhash' => str_random(32),
                ]);


            }

            if ($deviceCount > ($limitDevices + 5)) {

                throw new \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException('Device limit: ' . $limitDevices . '. Upgrade your price plan for send pushes to more devices.');
            }

        }


    }


private function isOrderAddr(Array $arr) {

    $na=[];

    $total=count($arr);

    foreach ($arr as $vv) {
        foreach ($vv as $k=>$kk) {
            array_push($na,[
                'order'=>$k,
                'address'=>$kk
            ]);
        }


    }
    if ($total == collect($na)->groupBy('order')->count()){
        return true;
    } else {
        return false;
    }


}

    private function sortArrayAddr(Array $arr) {



        $na=[];

        foreach ($arr as $vv) {
            foreach ($vv as $k=>$kk) {
                array_push($na,[
                    'order'=>$k,
                    'address'=>$kk
                ]);
            }


        }

        usort($na, function ($a, $b) {
            return $a['order'] - $b['order'];
        });

        $adrs=[];
        foreach ($na as $nav) {
            array_push($adrs,$nav['address']);



        }

        return $adrs;


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     * @return \Illuminate\Http\Response
     */
    public function storePushSend(Request $request)
    {
        //

        $json = $request->json()->all();

        Log::info($json);


        $validator = Validator::make($json, [
            'pk' => 'required',
            'data' => 'required',
        ]);

        if ($validator->fails()) {

            throw new ResourceException('Validating error: ' . $this->showErrorsFirst($validator->errors()->all()), $validator->errors());

        }


        if (UserApp::where('public_key', $json['pk'])->exists() == false) {
            throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException('App or User not found.');
        }


        $userApp = UserApp::where('public_key', $json['pk'])->first();


        if ($userApp->status == 'disable') {
            throw new \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException('App is disabled.');
        }

        if ($userApp->user->status == 'disable') {
            throw new \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException('User is disabled.');
        }


        $reqIp = request()->ip();

        if ($userApp->ip_mask != Null) {
            $userIpArr = explode(',', $userApp->ip_mask);

            if (!in_array($reqIp, $userIpArr)) {
                throw new \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException('Your IP ' . $reqIp . ' is not in white list.');
            }
        }

        if (str_contains($json['data'], '.') == false) {
            throw new ResourceException('Data string must contains dot symbol.');
        }


        $appData = explode('.', $json['data']);

        if (count($appData) != 2) {
            throw new ResourceException('Data string must two strings separated by dot symbol.');
        }

        $appClearData = $appData[0];
        $appDataString = json_decode(base64_decode($appData[0]), true);

        $clientSign = $appData[1];
        $serverSign = base64_encode(hash_hmac('sha256', $appClearData, $userApp->private_key, true));
        if ($serverSign != $clientSign) {
            throw new \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException('Your HMAC sign is not correct!');
        }


        $normData = $appDataString;


        //FIX json boolean
        if ($normData['flash_response']) {
            $normData['flash_response'] = true;

        } else {
            $normData['flash_response'] = false;
        }


       // dd($normData);
        //Log::info($normData);


        Validator::extend("emails", function ($attribute, $value, $parameters) {
            $rules = [
                'email' => 'email',
            ];


            if (is_array($value)) {

                $value = $this->sortArrayAddr($value);

                foreach ($value as $email) {
                    $data = [
                        'email' => $email,
                    ];
                    $validator = Validator::make($data, $rules);
                    if ($validator->fails()) {
                        return false;
                    }

                }
            } elseif (is_string($value)) {
                $data = [
                    'email' => $value,
                ];
                $validator = Validator::make($data, $rules);
                if ($validator->fails()) {
                    return false;
                }
            }

            return true;
        });

        $validatorDecoded = Validator::make($normData, [
            'addr_to'        => 'required|emails',
            'mode'           => 'required|in:push,code',
            'flash_response' => 'required|boolean',
            'code'           => 'required_if:mode,code|min:3|max:8',
        ],[
            'addr_to.emails'=>'Address must be valid email.'
        ]);

        if ($validatorDecoded->fails()) {

            throw new ResourceException('Validating error: ' . $this->showErrorsFirst($validatorDecoded->errors()->all()), $validatorDecoded->errors());


        }



        $this->limitPushes($userApp->user);
        $this->limitClients($userApp->user);
        $this->limitDevices($userApp->user);


        //Log::debug(print_r($normData['addr_to'],true));


        if (is_array($normData['addr_to'])) {


            $isOrder=$this->isOrderAddr($normData['addr_to']);


            $normData['addr_to'] = $this->sortArrayAddr($normData['addr_to']);


            //Log::debug(print_r($normData['addr_to'],true));


            if (count($normData['addr_to']) > 1) {
                if (count($normData['addr_to']) > 5) {
                    throw new \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException('Maximum of recipients is 5. For more, please contact us.');
                }

                if ($userApp->user->plan->limits()->where('key', 'routes')->first()->value == 'false') {
                    throw new \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException('Your price plan not support push routes service. Please upgrade your price plan.');
                }




                if ($isOrder == false) {
                    //Log::info('routes all');
                    return $this->fireRoutesAll($normData, $userApp);

                } else {
                    //Log::info('routes order');
                    return $this->fireRoutesOrder($normData, $userApp);
                }


            } elseif (count($normData['addr_to']) == 1) {
                Log::info('not routes, one');
                $normData['addr_to'] = array_shift($normData['addr_to']);
            }


        }


        if (User::where('email', $normData['addr_to'])->where('status', 'enable')->exists() == false) {

            throw new \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException('User is disabled or not exists.');
        }


        $user = User::where('email', $normData['addr_to'])->where('status', 'enable')->first();

        //dd($user);

        if ($user->devices->count() == 0) {
            throw new \Dingo\Api\Exception\ResourceException('User don\'t have any device');
        }

        if ($user->devices->count() > 0) {

            $uniqRequestID = str_random(32);


            $devices = $user->devices()->where('status', 'enable')->get();

            foreach ($devices as $device) {


                ($normData['code']) ? $decodeDataCode = $normData['code'] : $decodeDataCode = null;

                $pushRequest = PushRequest::create([
                    'app_id'          => $userApp->id,
                    'device_id'       => $device->id,
                    'hash'            => str_random(32),
                    'mode'            => $normData['mode'],
                    'code'            => $decodeDataCode,
                    'uniq_request_id' => $uniqRequestID,
                ]);


                $encodePush = [
                    'req_hash' => $pushRequest->hash,
                    'mode'     => $pushRequest->mode,
                    'code'     => $decodeDataCode,
                    'app_name' => $userApp->name,

                ];

                $this->dispatch(new SendPush($device->token, $device->os, $encodePush));


            }

            //print_r($device);


            $job = (new WebHook($uniqRequestID, 'timeout'))->delay(60);
            $this->dispatch($job);

            if (($normData['flash_response'] == true) || ($normData['mode'] == 'code')) {
                // dont wait response from mobile
                // app can check answer status by hash


                $encodedData = [
                    'req_hash' => $uniqRequestID,
                    'answer'   => null,
                ];

                $encodedData = $this->encodeData($encodedData, $userApp->private_key);

                $resData = [
                    'message' => 'Success push created!',
                    'data'    => $encodedData,
                ];

                return response()->json($resData, 200);
            } else {

                $sec = 1;
                while ($sec <= 30) {
                    $answer = Redis::get($uniqRequestID);
                    if ($answer) {

                        $encodedData = [
                            'req_hash' => $uniqRequestID,
                            'answer'   => (boolean)filter_var($answer, FILTER_VALIDATE_BOOLEAN),
                        ];

                        $encodedData = $this->encodeData($encodedData, $userApp->private_key);

                        $resData = [
                            'message' => 'Answer received!',
                            'data'    => $encodedData,
                        ];


                        Redis::del($uniqRequestID);

                        return response()->json($resData, 200);
                    }
                    $sec++;

                    sleep(1);
                }
                //return 'fail auth';

                //$pushRequest->update();

                $encodedData = [
                    'req_hash' => $uniqRequestID,
                    'answer'   => null,
                ];

                $encodedData = $this->encodeData($encodedData, $userApp->private_key);

                $resData = [
                    'message' => 'Answer not received!',
                    'data'    => $encodedData,
                ];

                return response()->json($resData, 200);


            }


        }


    }

    private function fireRoutesOrder($normData, UserApp $userApp)
    {
        $addresses = $normData['addr_to'];
        foreach ($addresses as $address) {
            if (User::where('email', $address)->where('status', 'enable')->exists() == false) {

                throw new \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException('User is disabled or not exists: ' . $address);
            }
            $user = User::where('email', $address)->where('status', 'enable')->first();
            if ($user->devices->count() == 0) {
                throw new \Dingo\Api\Exception\ResourceException('User ' . $address . ' don\'t have any device');
            }


        }
        $uniqReqId = str_random(32);

        $pushRequest = PushRequest::create([
            'app_id'          => $userApp->id,
            'device_id'       => null,
            'hash'            => str_random(32),
            'mode'            => 'route',
            'code'            => Null,
            'uniq_request_id' => $uniqReqId,
        ]);

        ksort($normData['addr_to']);

/*        reset($normData['addr_to']);
        $firstAddress = current($normData['addr_to']);
        $order = key($normData['addr_to']);*/

        $totalClients=count($normData['addr_to']);

        $job = (new WebHook($uniqReqId, 'timeout'))->delay(60*$totalClients);
        $this->dispatch($job);




        foreach ($normData['addr_to'] as $order => $address) {
            $user = User::where('email', $address)->where('status', 'enable')->first();
            if ($user->devices->count() > 0) {
                foreach ($user->devices()->where('status', 'enable')->get() as $device) {

                    $pushRoutes = PushRoutes::create([
                        'req_id'    => $pushRequest->id,
                        'device_id' => $device->id,
                        'client_id' => $user->id,
                        'order'     => $order,
                        'status'    => 'wait'

                    ]);

                }
            }


        }


        $clientID = PushRoutes::where('req_id',$pushRequest->id)
                    ->where('status','wait')
                    ->orderBy('order','asc')
                    ->first()->client_id;

        //$nextPushRoute->first()

        $nextPushRoute = PushRoutes::where('req_id',$pushRequest->id)
            ->where('status','wait')
            ->where('client_id', $clientID)
            ->get();






        foreach ($nextPushRoute as $pushRoute) {

            $pushRoute->update([
                'status'    => 'sended',
                'sended_dt' => Carbon::now(),
            ]);
            $encodePush = [
                'req_hash' => $pushRequest->hash,
                'mode'     => 'push',
                'code'     => Null,
                'app_name' => $userApp->name,

            ];

            $this->dispatch(new SendPush($pushRoute->device->token, $pushRoute->device->os, $encodePush));


        }





        $encodedData = [
            'req_hash' => $pushRequest->uniq_request_id,
            'answer'   => null,
        ];

        $encodedData = $this->encodeData($encodedData, $userApp->private_key);

        $resData = [
            'message' => 'Success push created!',
            'data'    => $encodedData,
        ];

        return response()->json($resData, 200);


    }

    private function fireRoutesAll($normData, UserApp $userApp)
    {

        $addresses = $normData['addr_to'];
        foreach ($addresses as $address) {
            if (User::where('email', $address)->where('status', 'enable')->exists() == false) {

                throw new \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException('User is disabled: ' . $address);
            }
            $user = User::where('email', $address)->where('status', 'enable')->first();
            if ($user->devices->count() == 0) {
                throw new \Dingo\Api\Exception\ResourceException('User ' . $address . ' don\'t have any device');
            }


        }


        $uniqReqId = str_random(32);

        $pushRequest = PushRequest::create([
            'app_id'          => $userApp->id,
            'device_id'       => null,
            'hash'            => str_random(32),
            'mode'            => 'route',
            'code'            => Null,
            'uniq_request_id' => $uniqReqId,
        ]);


        //TODO WEBHOOK HERE
        $job = (new WebHook($uniqReqId, 'timeout'))->delay(60);
        $this->dispatch($job);



        foreach ($normData['addr_to'] as $order => $address) {

            $user = User::where('email', $address)->where('status', 'enable')->first();

            if ($user->devices->count() > 0) {
                foreach ($user->devices()->where('status', 'enable')->get() as $device) {


                    $pushRoutes = PushRoutes::create([
                        'req_id'    => $pushRequest->id,
                        'device_id' => $device->id,
                        'client_id' => $user->id,
                        'order'     => '1',
                        'status'    => 'sended',
                        'sended_dt' => Carbon::now(),
                    ]);
                    $encodePush = [
                        'req_hash' => $pushRequest->hash,
                        'mode'     => 'push',
                        'code'     => Null,
                        'app_name' => $userApp->name,

                    ];

                    $this->dispatch(new SendPush($device->token, $device->os, $encodePush));


                }

            }


        }



        if ($normData['flash_response'] == true) {



            $encodedData = [
                'req_hash' => $pushRequest->uniq_request_id,
                'answer'   => null,
            ];

            $encodedData = $this->encodeData($encodedData, $userApp->private_key);

            $resData = [
                'message' => 'Success push created!',
                'data'    => $encodedData,
            ];

            return response()->json($resData, 200);

            //Log::info('ok!');

        } else {

            $sec = 1;
            while ($sec <= 30) {
                $answer = Redis::get($pushRequest->uniq_request_id);
                if ($answer) {

                    $encodedData = [
                        'req_hash' => $pushRequest->uniq_request_id,
                        'answer'   => (boolean)filter_var($answer, FILTER_VALIDATE_BOOLEAN),
                    ];

                    $encodedData = $this->encodeData($encodedData, $userApp->private_key);

                    $resData = [
                        'message' => 'Answer received!',
                        'data'    => $encodedData,
                    ];


                    Redis::del($pushRequest->uniq_request_id);

                    return response()->json($resData, 200);
                }
                $sec++;

                sleep(1);
            }
            //return 'fail auth';

            //$pushRequest->update();

            $encodedData = [
                'req_hash' => $pushRequest->uniq_request_id,
                'answer'   => null,
            ];

            $encodedData = $this->encodeData($encodedData, $userApp->private_key);

            $resData = [
                'message' => 'Answer not received!',
                'data'    => $encodedData,
            ];

            return response()->json($resData, 200);

        }


    }


    public function showQR(Request $request)
    {

        $json = $request->json()->all();


        $validator = Validator::make($json, [
            'pk'   => 'required',
            'data' => 'required',
        ]);

        if ($validator->fails()) {
            //throw new ResourceException('Validating error.', $validator->errors());
            throw new ResourceException('Validating error: ' . $this->showErrorsFirst($validator->errors()->all()), $validator->errors());

            // return response()->json(['error_message' => $validator->errors()], 400);
        }
        if (UserApp::where('public_key', $json['pk'])->exists() == false) {
            throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException('App not found.');
        }

        $userApp = UserApp::where('public_key', $json['pk'])->first();

        if ($userApp->status == 'disable') {
            throw new \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException('App is disabled.');
        }

        if ($userApp->user->status == 'disable') {
            throw new \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException('User is disabled.');
        }

        //ПРОВЕРКА ЛИМИТОВ/ПАКЕТОВ/БАЛАНСА/ПОДПИСКИ

        //проверка IP?

        $reqIp = request()->ip();

        if ($userApp->ip_mask != Null) {
            $userIpArr = explode(',', $userApp->ip_mask);

            if (!in_array($reqIp, $userIpArr)) {
                throw new \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException('Your IP ' . $reqIp . ' is not in white list.');
            }
        }

        $appData = explode('.', $json['data']);
        $appClearData = $appData[0];
        $appDataString = json_decode(base64_decode($appData[0]), true);
        $clientSign = $appData[1];

        $serverSign = base64_encode(hash_hmac('sha256', $appClearData, $userApp->private_key, true));


        if ($serverSign != $clientSign) {
            throw new \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException('Your HMAC sign is not correct!');
        }
        $normData = $appDataString;
        $imageConfig = $appDataString['image'];

        (array_key_exists('size', $imageConfig)) ? $qr['size'] = $imageConfig['size'] : $qr['size'] = 128;
        (array_key_exists('color', $imageConfig)) ? $qr['color'] = $imageConfig['color'] : $qr['color'] = '40,40,40';
        (array_key_exists('backgroundColor', $imageConfig)) ? $qr['backgroundColor'] = $imageConfig['backgroundColor'] : $qr['backgroundColor'] = '255,255,255';
        (array_key_exists('margin', $imageConfig)) ? $qr['margin'] = $imageConfig['margin'] : $qr['margin'] = 1;

        $pushRequest = PushRequest::create([
            'app_id'          => $userApp->id,
            'hash'            => str_random(32),
            'mode'            => 'qr',
            'uniq_request_id' => str_random(32),
        ]);

        $qrData = base64_encode(json_encode([
            'hash'            => $pushRequest->hash,
            'size'            => $qr['size'],
            'color'           => $qr['color'],
            'backgroundColor' => $qr['backgroundColor'],
            'margin'          => $qr['margin'],
        ]));


        $encodedData = [
            'req_hash' => $pushRequest->uniq_request_id,
            'qr_url'   => 'https://api.pushauth.io/qr/show/image/' . $qrData,
        ];

        $encodedData = $this->encodeData($encodedData, $userApp->private_key);

        $resData = [
            'data' => $encodedData,
        ];

        return response()->json($resData, 200);


        /*        } else {
                    throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException('App not found.');
                }*/


    }

    public function storeQR(Request $request)
    {

        $json = $request->json()->all();


        $validator = Validator::make($json, [
            'pk'   => 'required',
            'data' => 'required',
        ]);

        if ($validator->fails()) {
            //throw new ResourceException('Validating error.', $validator->errors());
            throw new ResourceException('Validating error: ' . $this->showErrorsFirst($validator->errors()->all()), $validator->errors());

            // return response()->json(['error_message' => $validator->errors()], 400);
        }

        if (UserDevices::where('public_key', $json['pk'])->exists() == false) {
            throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException('Device not found.');
        }

        $device = UserDevices::where('public_key', $json['pk'])->first();

        if ($device->user->status == 'disable') {
            throw new \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException('User is disabled.');
        }

        if ($device->status == 'disable') {
            throw new \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException('Device is disabled.');
        }





        $mobileData = explode('.', $json['data']);
        $mobileClearData = $mobileData[0];
        $mobileDataString = json_decode(base64_decode($mobileData[0]), true);
        $clientSign = $mobileData[1];
        //dd($mobileDataString);
        //$mobileDataHmac = $mobileData[2];


        $serverSign = base64_encode(hash_hmac('sha256', $mobileClearData, $device->private_key, true));
        //dd($serverSign);

        if ($clientSign != $serverSign) {
            throw new \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException('Your HMAC sign is not correct!');
        }


        if (PushRequest::where('hash', $mobileDataString['hash'])->where('mode', 'qr')->where('answer', Null)->where('device_id', Null)->exists() == false) {
            throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException('Push request not found.');
        }


        $pushRequest = PushRequest::where('hash', $mobileDataString['hash'])->where('mode', 'qr')->where('answer', Null)->where('device_id', Null)->first();

        //$answer = $normData['answer'];
        //if ($pushRequest->mode == 'code') { $answer = Null;}


        Redis::set($pushRequest->uniq_request_id, 'true');
        Redis::expire($pushRequest->uniq_request_id, 30);


        $pushRequest->update([
            'answer'           => 'true',
            'device_id'        => $device->id,
            'response_dt'      => Carbon::now(),
            'response_code'    => 200,
            'response_message' => 'Success used QR-code',
        ]);


        $resData = [
            'message' => 'Success answer received!',
        ];

        $job = (new WebHook($pushRequest->uniq_request_id, 'qr'));
        $this->dispatch($job);

        return response()->json($resData, 200);


        /*            } else {
                        throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException('Push request not found.');
                    }*/


        /*        } else {
                    throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException('Device not found.');
                }*/
    }

    //showQRImage
    public function showQRImage($id)
    {


        $inputData = json_decode(base64_decode($id), true);


        (array_key_exists('size', $inputData)) ? $qr['size'] = $inputData['size'] : $qr['size'] = 256;
        (array_key_exists('color', $inputData)) ? $qr['color'] = $inputData['color'] : $qr['color'] = '40,40,40';
        (array_key_exists('backgroundColor', $inputData)) ? $qr['backgroundColor'] = $inputData['backgroundColor'] : $qr['backgroundColor'] = '255,255,255';
        (array_key_exists('margin', $inputData)) ? $qr['margin'] = $inputData['margin'] : $qr['margin'] = 1;

        //dd($qr['color']);

        $color = explode(',', $qr['color']);
        $backgroundColor = explode(',', $qr['backgroundColor']);

        if (count($color) != 3) {
            throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException('Color argument must be in RGB (3 arguments)');
        }
        if (count($backgroundColor) != 3) {
            throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException('Background color argument must be in RGB (3 arguments)');
        }

        $file = QrCode::format('png')
            ->size($qr['size'])
            ->color($color[0], $color[1], $color[2])
            ->backgroundColor($backgroundColor[0], $backgroundColor[1], $backgroundColor[2])
            ->margin($qr['margin'])
            ->generate($inputData['hash']);

        return response($file)
            ->header('Content-Type', 'image/png')
            ->header('Pragma', 'public')
            ->header('Content-Disposition', 'inline; filename="qrcodeimg.png"')
            ->header('Cache-Control', 'max-age=60, must-revalidate');


    }


    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function showPushStatus(Request $request)
    {
        //

        //BaseEncrypter::

        /*
         * проверка пользователя и тд
         */
        $json = $request->json()->all();




        $validator = Validator::make($json, [
            'pk'   => 'required',
            'data' => 'required',
        ]);

        if ($validator->fails()) {
            //throw new ResourceException('Validating error.', $validator->errors());
            throw new ResourceException('Validating error: ' . $this->showErrorsFirst($validator->errors()->all()), $validator->errors());

            // return response()->json(['error_message' => $validator->errors()], 400);
        }
        if (UserApp::where('public_key', $json['pk'])->exists() == false) {
            throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException('App not found.');
        }


        $userApp = UserApp::where('public_key', $json['pk'])->first();

        if ($userApp->status == 'disable') {
            throw new \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException('App is disabled.');
        }

        if ($userApp->user->status == 'disable') {
            throw new \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException('User is disabled.');
        }

        //ПРОВЕРКА ЛИМИТОВ/ПАКЕТОВ/БАЛАНСА/ПОДПИСКИ

        //проверка IP?

        $reqIp = request()->ip();

        if ($userApp->ip_mask != Null) {
            $userIpArr = explode(',', $userApp->ip_mask);

            if (!in_array($reqIp, $userIpArr)) {
                throw new \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException('Your IP ' . $reqIp . ' is not in white list.');
            }
        }


        /*
                    $decodeData = $this->decodeData($json['data']);


                    $normData = $decodeData['data'];

                    $userSign = $decodeData['hmac'];

                    $userKey = $decodeData['key'];


                    $serverSign = base64_encode(hash_hmac('sha256', $userKey, $userApp->private_key, true));

                    if ($serverSign != $userSign) {
                        throw new \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException('Your HMAC sign is not correct!');
                    }

        */
        $appData = explode('.', $json['data']);
        $appClearData = $appData[0];
        $appDataString = json_decode(base64_decode($appData[0]), true);
        $clientSign = $appData[1];

        $serverSign = base64_encode(hash_hmac('sha256', $appClearData, $userApp->private_key, true));


        if ($serverSign != $clientSign) {
            throw new \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException('Your HMAC sign is not correct!');
        }
        $normData = $appDataString;

//            dd($normData);

        $validatorDecoded = Validator::make($normData, [
            'req_hash' => 'required',
        ]);

        if ($validatorDecoded->fails()) {
            //throw new ResourceException('Validating error.', $validatorDecoded->errors());
            throw new ResourceException('Validating error: ' . $this->showErrorsFirst($validator->errors()->all()), $validator->errors());

            // return response()->json(['error_message' => $validator->errors()], 400);
        }


        if (PushRequest::where('uniq_request_id', $normData['req_hash'])->where('app_id', $userApp->id)->count() == 0) {
            throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException('Push request not found.');
        }





        $pushRequest = PushRequest::where('uniq_request_id', $normData['req_hash'])
            ->where('app_id', $userApp->id)
            //->whereIn('answer', ['true', 'false'])
            ->orderBy('id', 'asc')
            ->first();

        $encodedData = [
            'answered' => (bool)false,
        ];


        if (in_array($pushRequest->mode, ['qr', 'route'])) {

            if ($pushRequest->response_code != Null) {

                ($pushRequest->response_dt) ? $pr_DT = Carbon::parse($pushRequest->response_dt)->timestamp : $pr_DT = null;

                $encodedData = [
                    'answered'         => (boolean)true,
                    'answer'           => (boolean)filter_var($pushRequest->answer, FILTER_VALIDATE_BOOLEAN),
                    'response_code'    => (int)$pushRequest->response_code,
                    'response_message' => $pushRequest->response_message,
                    'response_dt'      => $pr_DT,
                ];
            }


        }
        if ($pushRequest->mode == 'push') {

            if (PushRequest::where('uniq_request_id', $normData['req_hash'])
                ->where('app_id', $userApp->id)
                ->whereIn('answer',['true','false'])->count() > 0) {

                $pushRequest = PushRequest::where('uniq_request_id', $normData['req_hash'])
                    ->where('app_id', $userApp->id)
                    ->whereIn('answer',['true','false'])
                    ->orderBy('id','asc')
                    ->first();

                //Log::info('PR: '. print_r($pushRequest,true));

                ($pushRequest->response_dt) ? $pr_DT = Carbon::parse($pushRequest->response_dt)->timestamp : $pr_DT = null;

                $encodedData = [
                    'answered'         => (boolean)true,
                    'answer'           => (boolean)filter_var($pushRequest->answer, FILTER_VALIDATE_BOOLEAN),
                    'response_code'    => (int)$pushRequest->response_code,
                    'response_message' => $pushRequest->response_message,
                    'response_dt'      => $pr_DT,
                ];
            }



            }
        /*if ($pushRequest->mode == 'route') {
            //TODO ???
        }*/


        $encodedData = $this->encodeData($encodedData, $userApp->private_key);

        $resData = [
            'data' => $encodedData,
        ];

        return response()->json($resData, 200);


    }
}
