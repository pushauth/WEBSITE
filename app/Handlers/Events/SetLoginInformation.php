<?php

namespace PushAuth\Handlers\Events;


use Carbon\Carbon;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Illuminate\Http\Request;
use PushAuth\User;
use PushAuth\UserLogin;

class SetLoginInformation
{
    /**
     * Create the event handler.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        //
        $this->request = $request;
    }

    /**
     * Handle the event.
     *
     * @param  Events  $event
     * @return void
     */
    public function handle(User $user)
    {


        $user->logins()->create([
            'ip'=>$this->request->ip(),
            'user_agent'=>$this->request->header('User-Agent'),
            'login_dt'=>Carbon::now()
        ]);

    }
}
