<?php

namespace PushAuth\Http\Controllers\Frontend;

use Illuminate\Http\Request;

use PushAuth\Http\Requests;
use PushAuth\Http\Controllers\Controller;
use View;

class ContentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //return view();
    }

    public function showApi()
    {
        //
return redirect('/api/index.html');
    }

    public function showFaq()
    {
        //
        return view('frontend.faq');
    }
    public function showTeam()
    {
        //
        return view('frontend.team');
    }
    public function showJobs()
    {
        //
        return view('frontend.jobs');
    }
    public function showTerms()
    {
        //
        return view('frontend.terms');
    }
    public function showPolicy()
    {
        //
        return view('frontend.policy');
    }

    public function showTutorial($id = null)
    {
        //
        return view('frontend.tutorial');
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
