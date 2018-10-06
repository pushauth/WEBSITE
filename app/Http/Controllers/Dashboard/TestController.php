<?php

namespace PushAuth\Http\Controllers\Dashboard;

use Auth;
use Illuminate\Http\Request;

use PushAuth\Http\Requests;
use PushAuth\Http\Controllers\Controller;
use PushAuth\Jobs\SendPush;
use PushAuth\PushRequest;
use PushAuth\User;
use PushAuth\UserApp;

use Redis;
use Response;
use Validator;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use SEO;

class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($hash = null)
    {

        SEO::setTitle('Test application');

        $data = [
          'urlhash'=>$hash
        ];

        return view('dashboard.test.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }


    public function showStatus(Request $request)
    {
        $user=Auth::user();

        $devices = $request->devices;

        $validator = Validator::make($request->all(), [
            'devices' => 'required'
        ],
            [
                'devices.required'=>'Required field, not be null.'
            ]);

        if ($validator->fails()) {


            //return response()->json(404, $validator->messages());
            return Response::json($validator->messages(), 422);

        } else {


            $devices_arr = explode(',',$devices);
            foreach ($devices_arr as $device) {
                $dev = trim($device);

                if (PushRequest::where('hash',$dev)->where('test', 'true')->exists()) {
                    $pr = PushRequest::where('hash',$dev)->where('test', 'true')->first();

                    $answer = $pr->answer;
                    if ($answer != null) {
                        return Response::json(['msg'=>'<br> Answer is: '.$answer.'.'], 200);
                    } else {
                        return Response::json(['msg'=>'<br> Answer not received.'], 200);
                    }

                }
                else {
                    return Response::json(['app'=>['<br>Not correct Request Hash']], 422);
                }

            }


        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        //dd($request->all());
        //dd('stop');
        //
        $user=Auth::user();

        $validator = Validator::make($request->all(), [
            'app_hash' => 'required',
            'to_field'=>'required_if:to,false|email',
            'code'=>'required_if:mode,false|min:3|max:8'
        ],
            [
                'to_field.required_if'=>'Required To field, when you select remote push.',
                'to_field.email'=>'Field To must be valid email address',
                'code.required_if'=>'Required Code field, when you select push type of Code.',
                'code.min'=>'Field Code must be min 3 character',
                'code.max'=>'Field Code must be max 8 character',
            ]);

        if ($validator->fails()) {


            //return response()->json(404, $validator->messages());
            return Response::json($validator->messages(), 422);

        } else {
            //return Response::json(['3'=>'2'], 422);





            $appHash = $request->app_hash;

            //dd($request->app_hash);

            try {
                $app = UserApp::where('urlhash', $appHash)->where('user_id',$user->id)->where('status', 'enable')->firstOrFail();
            } catch (ModelNotFoundException $e) {
                return Response::json(['app'=>['App is not found or disabled.']], 422);
            }

            ($request->mode == 'true') ? $pushMode = 'push' : $pushMode = 'code';
            ($request->code) ? $pushCode = $request->code : $pushCode = Null;


//Local push
if ($request->to == 'true') {




}

//remote push
else {
    if (User::where('email', $request->to_field)->where('status', 'enable')->exists() == false) {
        return Response::json(['app'=>['<br>Client with this email not found or disabled.']], 422);
    }
        $client = User::where('email', $request->to_field)->where('status', 'enable')->first();

$PushRequestsHashsArr=[];
        if ($client->devices()->where('status','enable')->count() == 0) {
            return Response::json(['app'=>['<br>Client don\'t have any devices.']], 422);
        }



            $uniq_request_id=str_random(32);

            foreach ($client->devices()->where('status','enable')->get() as $device) {

                $pushRequest = PushRequest::create([
                    'app_id'=>$app->id,
                    'device_id'=>$device->id,
                    'hash'=>str_random(32),
                    'mode'=>$pushMode,
                    'code'=>$pushCode,
                    'test'=>'true',
                    'uniq_request_id'=>$uniq_request_id

                ]);
                array_push($PushRequestsHashsArr, $pushRequest->hash);

                $encodePush = [
                    'req_hash'=>$pushRequest->hash,
                    'mode'=>$pushRequest->mode,
                    'code'=>$pushCode,
                    'app_name'=>$app->name
                ];

                $this->dispatch(new SendPush($device->token, $device->os, $encodePush));




            }



            if ($pushMode == 'push') {

                if ($request->wait_response == 'true') {


                    $sec = 1;
                    while ($sec <= 30) {
                        $answer = Redis::get($uniq_request_id);
                        if ($answer) {

                            Redis::del($uniq_request_id);

                            return Response::json(['msg'=>'<br>Received answer from remote device! Answer is: '.$answer.'.'], 200);
                        }
                        $sec++;

                        sleep(1);
                    }
                    return Response::json(['msg'=>'<br>Dont receive answer from remote device.',
                                           'devices'=>$PushRequestsHashsArr], 200);



                } else {
                    return Response::json(['msg'=>'<br>All pushes[auth] are sended. You can check answer by Request Hash: '.implode(', ', $PushRequestsHashsArr),
                                        'devices'=>$PushRequestsHashsArr], 200);
                }


            } else {
                return Response::json(['msg'=>'<br>All pushes[code] are sended.','devices'=>$PushRequestsHashsArr], 200);
            }

/*        }
        else {
            return Response::json(['app'=>['<br>Client don\'t have any devices.']], 422);
        }*/




/*    else {
        return Response::json(['app'=>['<br>Client with this email not found or disabled.']], 422);
    }*/
}







        }
        /*
         * app_hash
to
to_field
mode
code
wait_response
         */




    }


    public function showServerBase64(Request $request)
    {
        $user=Auth::user();

        $validator = Validator::make($request->all(), [
            'str' => 'required'
        ],
            [
                'str.required'=>'Required string field'
            ]);

        if ($validator->fails()) {


            //return response()->json(404, $validator->messages());
            return Response::json($validator->messages(), 422);

        } else {


            return Response::json(['msg'=>base64_encode(trim($request->str))], 200);

        }
    }

    public function showServerHMAC(Request $request)
    {
        $user=Auth::user();

        $validator = Validator::make($request->all(), [
            'str' => 'required',
            'pass'=>'required'
        ],
            [
                'str.required'=>'Required string field',
                'pass.required'=>'Required password field'
            ]);

        if ($validator->fails()) {


            //return response()->json(404, $validator->messages());
            return Response::json($validator->messages(), 422);

        } else {

$hmac = base64_encode(hash_hmac('sha256', base64_encode(trim($request->str)), trim($request->pass), true));

            //$hmac =

            return Response::json(['msg'=>$hmac], 200);

        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showServer()
    {
        //
        SEO::setTitle('Test server side');
        return view('dashboard.test.server');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
