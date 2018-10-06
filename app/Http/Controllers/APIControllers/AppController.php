<?php

namespace PushAuth\Http\Controllers\APIControllers;

use Cache;
use Illuminate\Http\Request;

use PushAuth\Http\Requests;
use PushAuth\Http\Controllers\Controller;
use PushAuth\UserApp;
use PushAuth\UserDevices;
use Validator;
use Dingo\Api\Exception\ResourceException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use PushAuth\PushRequest;

use Image;

use Log;

class AppController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $resData=[
            'data'=> 'API works fine! Please read: https://dashboard.pushauth.io/support/api'

        ];
        return response()->json($resData, 200);
    }

    public function updateFlag($flag)
    {


        if ($flag == 'true') {
            Cache::forever('testFlag', true);
        }
        else if ($flag == 'false') {
            Cache::forever('testFlag', false);
        }

        $flag = Cache::get('testFlag');


        $resData=[
            'flag'=> $flag

        ];
        return response()->json($resData, 200);
    }

    public function testFlag()
    {
        //


        $flag = false;
        if (Cache::has('testFlag')) {
            $flag = Cache::get('testFlag');
        }


        $resData=[
            'flag'=> $flag

        ];
        return response()->json($resData, 200);
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    public function showLogo($hash, Request $request)
    {
        if ($hash == 'default_app.png') {
            $imgPath = public_path('assets/images/default_logo.png');

            $img = Image::cache(function ($image) use ($imgPath) {
                //global $imgPath;
                $image->make($imgPath)->fit(150, 150, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
            }, 10, true);

            return $img->response();
        }
        else {
            if (UserApp::where('img', $hash)->exists()) {
                $userApp = UserApp::where('img', $hash)->first();


                $imgPath = storage_path('users/' . $userApp->user_id . '/' . $userApp->img);

                $img = Image::cache(function ($image) use ($imgPath) {
                    //global $imgPath;
                    $image->make($imgPath)->fit(150, 150, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                }, 10, true);

                return $img->response();




            }
            else {
                throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException('App image not found.');
            }
        }
    }



    public function showErrorsFirst($errors) {

        return $errors[0];

    }

    public function test(Request $request)
    {
        dd(base64_decode("eyJyZXFfaGFzaCI6Inpub3N5clV3dTBlNW9Ta00zRU82UlE4Um1LV1NNcXdtIn0="));

//eyJyZXFfaGFzaCI6Inpub3N5clV3dTBlNW9Ta00zRU82UlE4Um1LV1NNcXdtIn0=.XpqvWtxUy05aU3R79nlzLAjhVKL/q3ixDq0vFfPyQ4Y=

        return response()->json([
'data'=>base64_encode(hash_hmac('sha256','eyJyZXFfaGFzaCI6Inpub3N5clV3dTBlNW9Ta00zRU82UlE4Um1LV1NNcXdtIn0=','DWo0WStzkGlKkYONrp9cyH4aGsVfhSIf',true))
        ], 200);

    }

    public function showStats(Request $request)
    {
//
        $json = $request->json()->all();


        $validator = Validator::make($json, [
            'pk' => 'required',
            'data'=>'required'
        ]);

        if ($validator->fails()) {
            //throw new ResourceException('Validating error.', $validator->errors());
            throw new ResourceException('Validating error: '.$this->showErrorsFirst($validator->errors()->all()), $validator->errors());

            // return response()->json(['error_message' => $validator->errors()], 400);
        }



        if (UserDevices::where('public_key', $json['pk'])->exists()) {

            $app = UserApp::where('public_key', $json['pk'])->first();

            if ($app->user->status == 'disable') {
                throw new \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException('User is disabled.');
            }
            if ($app->status == 'disable') {
                throw new \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException('Device is disabled.');
            }


            $mobileData = explode('.', $json['data']);
            $mobileClearData = $mobileData[0];
            $mobileDataString = json_decode(base64_decode($mobileData[0]), true);
            $clientSign = $mobileData[1];

            $serverSign = base64_encode(hash_hmac('sha256', $mobileClearData, $app->private_key, true));

            if ($clientSign != $serverSign) {
                throw new \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException('Your HMAC sign is not correct!');
            }



            $reqIp = request()->ip();

            if ($app->ip_mask != Null) {
                $userIpArr = explode(',', $app->ip_mask);

                if (!in_array($reqIp, $userIpArr)) {
                    throw new \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException('Your IP ' . $reqIp . ' is not in white list.');
                }
            }




                $resData = [
                    'price_plan'  => '',
                    'limits'=>[
                        'pushes_day'=>'',
                        'pushes_month'=>'',
                        'apps'=>'',
                        'devices'=>'',
                        'clients'=>''
                    ],
                    'current'=>[
                        'pushes_day'=>'',
                        'pushes_month'=>'',
                        'apps'=>'',
                        'devices'=>'',
                        'clients'=>''
                    ]
                ];

                $encData = $this->encodeData($resData, $device->private_key);
                //$encData=$data;

                $resData=[
                    'data'=> $encData

                ];
                return response()->json($resData, 200);



        }
        else {
            throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException('Device not found.');
        }



    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        //
        $json = $request->json()->all();


        $validator = Validator::make($json, [
            'pk' => 'required',
            'data'=>'required'
        ]);

        if ($validator->fails()) {
            //throw new ResourceException('Validating error.', $validator->errors());
            throw new ResourceException('Validating error: '.$this->showErrorsFirst($validator->errors()->all()), $validator->errors());

            // return response()->json(['error_message' => $validator->errors()], 400);
        }



        if (UserDevices::where('public_key', $json['pk'])->exists()) {

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


            $req_hash = $mobileDataString['req_hash'];


            if (PushRequest::where('hash', $req_hash)->exists()) {
                $pushRequest = PushRequest::where('hash', $req_hash)->first();

                $app = $pushRequest->app;

                if ($app->status == 'disable') {
                    throw new \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException('App is disabled.');
                }

                if ($app->user->status == 'disable') {
                    throw new \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException('User is disabled.');
                }

                ($app->img == null) ? $appImg = "default_app.png" : $appImg = $app->img;

                $resData = [
                    'name'  => $app->name,
                    'url'   => $app->url,
                    'logo'  => 'https://api.pushauth.'.env('DOMAIN_LTD','io').'/'.$appImg,
                    'about' => $app->about
                ];

                $encData = $this->encodeData($resData, $device->private_key);
                //$encData=$data;

                $resData=[
                    'data'=> $encData

                ];
                return response()->json($resData, 200);



            } else {
                throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException('Push request not found.');
            }

        }
        else {
            throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException('Device not found.');
        }

    }


}
