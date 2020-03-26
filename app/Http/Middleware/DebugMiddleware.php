<?php

namespace App\Http\Middleware;

use Closure;

class DebugMiddleware
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
        if(!env('APP_DEBUG')){
            return redirect(route('home'));
        }
        return $next($request);
    }
}
