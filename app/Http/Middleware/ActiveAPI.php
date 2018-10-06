<?php

namespace PushAuth\Http\Middleware;

use Closure;

class ActiveAPI
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (env('ACTIVE_API',true) == false) {

            throw new \Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException('API is disabled!');


        }
        return $next($request);
    }
}
