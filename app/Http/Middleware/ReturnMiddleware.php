<?php

namespace App\Http\Middleware;

use Closure;

class ReturnMiddleware
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
        if(Auth::user()->isReturnDay()){
            return $next($request);
        }
        return redirect(route('home'));
    }
}
