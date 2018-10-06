<?php

namespace PushAuth\Http\Controllers\Auth;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

use PushAuth\Http\Requests;
use PushAuth\Http\Controllers\Controller;
use PushAuth\User;
use PushAuth\UserDeviceConfirm;
use PushAuth\UserDevices;

class ConfirmUserDeviceController extends Controller
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
    public function store(Request $request, $hash)
    {
        //

        if ($hash) {

            try {
            $confirm = UserDeviceConfirm::where('urlhash',$request->hash)
                ->where('status', 'false')
                ->firstOrFail();
                }
                catch (ModelNotFoundException $e) {
                    //dd('4');
                    return abort(404);
                }


                $confirm->update([
                    'status'=>'true',
                    'confirm_dt'=>Carbon::now()
                ]);

            if (($confirm->user_id == Null) && ($confirm->with_user == 'true')) {

                //Если нужно создать пользователя
                //TODO


                if (User::where('email', $confirm->email)->exists()) {
                    return abort(404);
                }
                $mailStr = explode('@', $confirm->email);
                $name = $mailStr['0'].date('HisdmY');


                $user = User::create([
                    'name' => $name,
                    'email' => $confirm->email,
                    'password' => bcrypt(str_random(8)),
                    'confirmed'=>'false'
                ]);
                $user->profile()->create([]);

                $user->role()->create([]);

                $user->plan()->create(['plan_id'=>'1']);

                $user->msgLogLast()->create([]);

                $user->notifications()->create([
                    'subject'=>'We are happy to see you!',
                    'body'=>view('dashboard.notifys.firstlogin')->render(),
                    'urlhash'=>str_random(32)
                ]);

                $confirm->update(['user_id'=>$user->id]);
            }



            //if device exists
            if (UserDevices::where('uuid', $confirm->uuid)->exists()) {
                UserDevices::where('uuid', $confirm->uuid)->update([
                    'user_id'=>$confirm->user_id,
                    'token'=>$confirm->token,
                    'status'=>'enable',
                    'public_key'=>str_random(32),
                    'private_key'=>str_random(32),

                    'name'=>$confirm->name,
                    'vendor'=>$confirm->vendor,
                    'os_detail'=>$confirm->os_detail

                ]);
            } else {
                UserDevices::create([

                    'uuid'=>$confirm->uuid,
                    'token'=>$confirm->token,
                    'os'=>$confirm->os,
                    'user_id'=>$confirm->user_id,
                    'public_key'=>str_random(32),
                    'private_key'=>str_random(32),

                    'name'=>$confirm->name,
                    'vendor'=>$confirm->vendor,
                    'os_detail'=>$confirm->os_detail,

                ]);
            }


            return view('messages.confirmation');


        }
        else {
            return abort(404);
        }





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
