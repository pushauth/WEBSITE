<?php

namespace PushAuth\Http\Controllers\Dashboard;

use Illuminate\Http\Request;

use PushAuth\Http\Requests;
use PushAuth\Http\Controllers\Controller;
use PushAuth\PushRequest;

use PushAuth\PushRoutes;
use SEO;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        SEO::setTitle('Dashboard');

        $user = \Auth::user();

        $apps=$user->app()->lists('id')->toArray();
        //dd($apps);

       $pushReq = PushRequest::whereIn('app_id',$apps)->where('test','false')->whereIn('mode',['code','push','route'])->get();

        $pushesCount = $pushReq->count();

        $pushReqsArr=$pushReq->lists('id')->toArray();
        $pushReqsArr=array_unique($pushReqsArr);


        $clients = PushRequest::whereIn('app_id',$apps)->where('test','false')->lists('device_id')->toArray();
        $devicesRoute= PushRoutes::whereIn('req_id',$pushReqsArr)->lists('device_id')->toArray();

        $clients = array_merge($devicesRoute,$clients);
        $clients = array_filter($clients, function($var){return !is_null($var);} );
/*dd($clients);*/
        //dd(count(array_unique($clients)));


        $pushes = PushRequest::whereIn('app_id',$apps)->orderBy('id', 'desc')->take(10)->get();

        //dd($pushes);

        $data = [
        'pushesCount'=>$pushesCount,
        'devices'=>count(array_unique($clients)),
        'pushes'=>$pushes
        ];



        return view('dashboard.index')->with($data);
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
