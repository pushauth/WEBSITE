<?php

namespace PushAuth\Http\Controllers\Frontend;


use Illuminate\Http\Request;

use PushAuth\Classes\PushAuth;
use PushAuth\Http\Requests;
use PushAuth\Http\Controllers\Controller;
use PushAuth\User;
use Redis;
use Response;
use Validator;

use GrahamCampbell\Throttle\Facades\Throttle;



class MainController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('frontend.index');
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
    public function showExampleStatus($id)
    {

        if ($id == 'success') {

            return view('frontend.exampleYes');

        }elseif ($id == 'denied') {

            return view('frontend.exampleNo');
        }

    }
    public function showExample()
    {
        //

        $authRequest = new PushAuth('tmukeggpDg51dCibDBVdOmWPKrsWg5ZY', 'iCD90UOsz0VxX5JOFRm1LdiPTrqOOvza');

        $qr = $authRequest->qrconfig([
            'margin'=>'5',
            'size'=>'256',
            'color'=>'237,114,205'
        ])->qr();

        $data = [
            'qr'=>$qr['qr_url'],
            'hash'=>$qr['req_hash']
        ];
        return view('frontend.example')->with($data);
    }

    public function checkQrCode(Request $request ) {

        $authRequest = new PushAuth('tmukeggpDg51dCibDBVdOmWPKrsWg5ZY', 'iCD90UOsz0VxX5JOFRm1LdiPTrqOOvza');
//dd($request->hash);

        try {
            $status =  $authRequest->requestStatus($request->hash);
        } catch (\Exception $e) {

            return Response::json([
                'code'=>'212',
                //'url'=>'https://google.com/'
            ], 200);

        }




        if ($status['answered'] == true) {
            if ($status['answer'] == true) {
                return Response::json([
                    'code'=>'200',
                    'url'=>route('frontend.example.status','success')
                ], 200);
            }

        }

        return Response::json([
            'code'=>'212',
            //'url'=>'https://google.com/'
        ], 200);
}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function storeExample(Request $request)
    {



        $validator = Validator::make($request->all(), [
            'to' => 'required|email',
        ],
            [
                'to.email'=>'Field To must be valid email address',
            ]);

        if ($validator->fails()) {


            //return response()->json(404, $validator->messages());
            return Response::json($validator->messages(), 422);

        } else {

            $authRequest = new PushAuth('tmukeggpDg51dCibDBVdOmWPKrsWg5ZY', 'iCD90UOsz0VxX5JOFRm1LdiPTrqOOvza');

            if ($request->mode == 'true') {

                try {
                    $request = $authRequest->to($request->to)
                        ->mode('push')
                        ->response(false)
                        ->send();
                } catch (\Exception $e) {

                    return Response::json(['app'=>[$e->getMessage()]], 422);

                }



                if (is_null($authRequest->isAccept())) {
                    return Response::json(['app'=>['NO ANSWER']], 422);
                }
                if ($authRequest->isAccept() == true) {
                    return Response::json(['url'=>route('frontend.example.status','success')], 200);
                } elseif ($authRequest->isAccept() == false) {
                    return Response::json(['url'=>route('frontend.example.status','denied')], 200);
                }


            }

            if ($request->mode == 'false') {

                if ($request->req_hash) {

                    //dd('stop');

                $codeRedis = Redis::get('test_'.$request->req_hash);
                    if ($codeRedis) {
                        if ($codeRedis == $request->code) {
                            return Response::json(['url'=>route('frontend.example.status','success')], 200);
                        }else {
                            return Response::json(['url'=>route('frontend.example.status','denied')], 200);
                        }
                    }else{
                        return Response::json(['app'=>['Answer timeout... Try new auth!']], 422);
                    }



                } else {
                    $code = str_random(4);
                    try {
                        $requestAuth = $authRequest->to($request->to)
                            ->mode('code')
                            ->code($code)
                            ->send();

                    } catch (\Exception $e) {

                        return Response::json(['app'=>[$e->getMessage()]], 422);

                    }

                    Redis::set('test_'.$requestAuth, $code);
                    Redis::expire('test_'.$requestAuth, 50);

                    return Response::json(['code'=>'required',
                                           'req_hash'=>$requestAuth], 200);




                }




            }











        }




/*
        return Response::json(['code'=>'required',
                               'req_hash'=>'12345'], 200);

        return Response::json(['url'=>['http://success_url/....']], 200);

        return Response::json(['app'=>['Not correct Request Hash']], 422);*/


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
