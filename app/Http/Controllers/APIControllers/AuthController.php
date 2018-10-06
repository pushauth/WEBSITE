<?php

namespace PushAuth\Http\Controllers\APIControllers;

use ClassesWithParents\D;
use Dingo\Api\Exception\ResourceException;
use Dingo\Api\Exception\StoreResourceFailedException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;
use Mail;
use PushAuth\DhExchange;
use PushAuth\Http\Requests;
use PushAuth\Http\Controllers\Controller;
use PushAuth\Jobs\SendPush;
use PushAuth\User;
use PushAuth\UserDeviceConfirm;
use PushAuth\UserDevices;
use Validator;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return response()->json(['error_message' => 'could_not_create_token'], 200);
    }



    private function randomNumber($length) {
        $result = '';

        for($i = 0; $i < $length; $i++) {
            $result .= mt_rand(1, 9);
        }

        return (integer)$result;
    }


    public function showErrorsFirst($errors) {

            return $errors[0];

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function storeRegister(Request $request)
    {

        //
        /*
         *
         * email
            device_uuid
            device_token
            device_type
         */
        $json = $request->json()->all();



        if (!array_key_exists('device_name', $json)) {
            $json['device_name']=null;
        }
        if (!array_key_exists('device_vendor', $json)) {
            $json['device_vendor']=null;
        }
        if (!array_key_exists('device_os_detail', $json)) {
            $json['device_os_detail']=null;
        }

        $validator = Validator::make($json, [
            'email' => 'required|email',
            'device_uuid' => 'required',
            'device_token' => 'required',
            'device_type' => 'required',

           // 'device_name' => 'required',
           // 'device_vendor' => 'required',
           // 'device_os_detail' => 'required',

        ]);

        if ($validator->fails()) {
            throw new ResourceException('Validating error: '.$this->showErrorsFirst($validator->errors()->all()), $validator->errors());
           // return response()->json(['error_message' => $validator->errors()], 400);
        }

        //есть ли пользователь?
        if (User::where('email', $json['email'])->exists()) {

            $user=User::where('email', $json['email'])->first();

            if ($user->status == 'disable') {

                //пользователь деактивен
                throw new \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException('User is disabled.');

            }


            //Only for test account
            if ($json['email'] == 'test@pushauth.io') {

                $device = UserDevices::create([
                    'uuid'=>$json['device_uuid'],
                    'token'=>$json['device_token'],
                    'os'=>$json['device_type'],
                    'user_id'=>$user->id,
                    'public_key'=>str_random(32),
                    'private_key'=>str_random(32),

                    'name'=>$json['device_name'],
                    'vendor'=>$json['device_vendor'],
                    'os_detail'=>$json['device_os_detail'],


                ]);

                $encodePush=[
                    'mode'=>'auth',
                    'private_key'=>$device->private_key
                ];

                // $encodePush = json_encode($encodePush);


                $this->dispatch(new SendPush($device->token, $device->os, $encodePush));


                $resData=[
                    'message' => 'Auth success!',
                    'is_access'=>(boolean)true,
                    'public_key'=> $device->public_key
                ];
                return response()->json($resData, 200);

            }

            //есть ли у пользователя устройство?
            if ($user->devices()->where('uuid', $json['device_uuid'])->exists()) {
                //есть устройство

                    //есть ли у устройства ключи?
                $device = $user->devices()->where('uuid', $json['device_uuid'])->first();
                if ($device->status == 'disable') {

                    //устройство деактивно
                    throw new \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException('Device is disabled.');

                }


                $device->update([
                    'public_key'=>str_random(32),
                    'private_key'=>str_random(32),
                    'token'=>$json['device_token']
                ]);


                $encodePush=[
                    'mode'=>'auth',
                    'private_key'=>$device->private_key
                ];

               // $encodePush = json_encode($encodePush);


                $this->dispatch(new SendPush($device->token, $device->os, $encodePush));


                    $resData=[
                        'message' => 'Auth success!',
                        'is_access'=>(boolean)true,
                        'public_key'=> $device->public_key
                    ];
                    return response()->json($resData, 200);


                //return response()->json(['data' => 'device exists'], 200);
            }
            else {
                //нет устройства
                //return response()->json(['data' => 'device not exists'], 404);

                if (UserDevices::where('uuid', $json['device_uuid'])->where('user_id','!=', $user->id)->exists()) {
                    //устройство принадлежит другому пользователю
                    //переводим устройство новому пользователю и подтверждаем
                    //подтверждение!

                    $confirm = UserDeviceConfirm::create([
                        'user_id'=>$user->id,
                        'os'=>$json['device_type'],
                        'uuid'=>$json['device_uuid'],
                        'token'=>$json['device_token'],
                        'urlhash'=>str_random(32),

                        'name'=>$json['device_name'],
                        'vendor'=>$json['device_vendor'],
                        'os_detail'=>$json['device_os_detail'],

                    ]);
                    //Mail notify



                    $dataMail = [
                        'url'=>route('confirmation',$confirm->urlhash)
                    ];


                    Mail::queue(['text' => 'emails.confirmation.device'], $dataMail, function ($message) use ($user) {
                        $message->from(env('MAIL_ADDRESS'), 'PushAuth');
                        $message->subject('PushAuth Confirmation Device');
                        $message->to($user->email);
                    });

                    $resData=[
                        'message' => 'Please check your email for confirmation!',
                        'is_access'=>(boolean)false,
                        'status_code'=>(int)428
                    ];
                    return response()->json($resData, 428);

                } else {
                    //устройство не принадлежит никому
                    //добавление устройства и авторизация
                    //подтверждение!
                  $confirm = UserDeviceConfirm::create([
                        'user_id'=>$user->id,
                        'os'=>$json['device_type'],
                        'uuid'=>$json['device_uuid'],
                        'token'=>$json['device_token'],
                        'urlhash'=>str_random(32),

                        'name'=>$json['device_name'],
                        'vendor'=>$json['device_vendor'],
                        'os_detail'=>$json['device_os_detail'],

                  ]);



                    $dataMail = [
                        'url'=>route('confirmation',$confirm->urlhash)
                    ];


                    Mail::queue(['text' => 'emails.confirmation.device'], $dataMail, function ($message) use ($user) {
                        $message->from(env('MAIL_ADDRESS'), 'PushAuth');
                        $message->subject('PushAuth Confirmation Device');
                        $message->to($user->email);
                    });


                    $resData=[
                        'message' => 'Please check your email for confirmation!',
                        'is_access'=>(boolean)false,
                        'status_code'=>(int)428
                    ];
                    return response()->json($resData, 428);

/*                    UserDevices::create([
                        'uuid'=>$json['device_uuid'],
                        'token'=>$json['device_token'],
                        'os'=>$json['device_type'],
                        'user_id'=>$user->id,
                    ]);*/
                }



            }
        }
        else {
            //пользователя нет
            if (UserDevices::where('uuid', $json['device_uuid'])->exists()) {
                //устройство принадлежит другому пользователю
                //переводим устройство новому пользователю

                $confirm = UserDeviceConfirm::create([
                   // 'user_id'=>$user->id,
                    'os'=>$json['device_type'],
                    'uuid'=>$json['device_uuid'],
                    'token'=>$json['device_token'],
                    'urlhash'=>str_random(32),
                    'with_user'=>'true',
                    'email'=>$json['email'],

                   'name'=>$json['device_name'],
                   'vendor'=>$json['device_vendor'],
                   'os_detail'=>$json['device_os_detail'],

                ]);


                $dataMail = [
                    'url'=>route('confirmation',$confirm->urlhash)

                ];


                Mail::queue(['text' => 'emails.confirmation.deviceWithUser'], $dataMail, function ($message) use ($json) {
                    $message->from(env('MAIL_ADDRESS'), 'PushAuth');
                    $message->subject('PushAuth Confirmation Register');
                    $message->to($json['email']);
                });
                /*
                 * сначала регистрация нового пользователя и подтверждение
                 * потом подтверждение устройства
                 */


                $resData=[
                    'message' => 'Please check your email for confirmation!',
                    'is_access'=>(boolean)false,
                    'status_code'=>(int)428
                ];
                return response()->json($resData, 428);
            } else {
                //устройство не принадлежит никому
                //регистрация
                //подтверждение!
                $confirm = UserDeviceConfirm::create([
                    // 'user_id'=>$user->id,
                    'os'=>$json['device_type'],
                    'uuid'=>$json['device_uuid'],
                    'token'=>$json['device_token'],
                    'urlhash'=>str_random(32),
                    'with_user'=>'true',
                    'email'=>$json['email'],

                    'name'=>$json['device_name'],
                    'vendor'=>$json['device_vendor'],
                    'os_detail'=>$json['device_os_detail'],

                ]);

                $dataMail = [
                    'url'=>route('confirmation',$confirm->urlhash)

                ];


                Mail::queue(['text' => 'emails.confirmation.deviceWithUser'], $dataMail, function ($message) use ($json) {
                    $message->from(env('MAIL_ADDRESS'), 'PushAuth');
                    $message->subject('PushAuth Confirmation Register');
                    $message->to($json['email']);
                });


                $resData=[
                    'message' => 'Please check your email for confirmation!',
                    'is_access'=>(boolean)false,
                    'status_code'=>(int)428
                ];
                return response()->json($resData, 428);
            }

            //return response()->json(['data' => 'user not exists'], 200);
        }




    }


    public function storeLogout(Request $request) {

        $json = $request->json()->all();

        Log::info('fired logout with: '. print_r($json,true));

        $pk = $json['pk'];


        $validator = Validator::make($json, [
            'pk' => 'required'

        ]);

        if ($validator->fails()) {
           // throw new ResourceException('Validating error.', $validator->errors());
            throw new ResourceException('Validating error: '.$this->showErrorsFirst($validator->errors()->all()), $validator->errors());

            // return response()->json(['error_message' => $validator->errors()], 400);
        }



        if (UserDevices::where('public_key', $pk)->exists() == false) {
            throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException('Device not found.');
        }

        $uDevice = UserDevices::where('public_key', $pk)->firstOrFail();



        $uDevice->pushes()->delete();
        $uDevice->routes()->delete();
        $uDevice->delete();


            $resData = [
                'message'=>'Device deleted successful!'
            ];
            return response()->json($resData, 200);





    }





}
