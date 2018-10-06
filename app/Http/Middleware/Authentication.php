<?php
/**
 * Copyright (c) 2017.  Yaroslav Snisar
 * info@snisar.com
 */

namespace PushAuth\Http\Middleware;

use Closure;


class Authentication
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @param                           $role
     * @return mixed
     */
    public function handle($request, Closure $next, ...$role)
    {




        if (auth()->check() && (in_array(auth()->user()->role->role, $role))) {
            return $next($request);
        }

        return redirect()->route('login');
        //return $next($request);
    }
}
