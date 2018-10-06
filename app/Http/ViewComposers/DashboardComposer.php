<?php
/**
 * Copyright (c) 2017.  Yaroslav Snisar
 * info@snisar.com
 */

namespace PushAuth\Http\ViewComposers;


use Auth;

use View;


//use Illuminate\View\View;

class DashboardComposer
{

    /**
     * Create a movie composer.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Bind data to the view.
     *
     * @param  View $view
     * @return void
     */
    public function compose()
    {
        if (Auth::check()) {
            $user = Auth::user();

            if ($user->profile->user_img == Null) {

                $user->img =  route('profile.showImage', 'default_avatar.png');;
            } else {
                $user->img =  route('profile.showImage', $user->profile->user_img);
            }


            View::share([

                'user' => $user


            ]);
        }
//dd('work');


    }
}