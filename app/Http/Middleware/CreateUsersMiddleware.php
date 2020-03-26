<?php

namespace App\Http\Middleware;

use App\Helpers\Dates;
use Closure;
use Illuminate\Support\Facades\Auth;

class CreateUsersMiddleware
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

        if(Auth::user()->role == 'superadmin' || (Auth::user()->role == 'admin' && Auth::user()->group && (Auth::user()->group->branch > Auth::user()->sponsored->count()) ) || (Auth::user()->role == 'sponsored' && Auth::user()->group && (Auth::user()->group->branch > Auth::user()->sponsored->count()) && (Dates::getNameDay( session('day') ) == 'Lunes' || Dates::getNameDay( session('day') ) == 'Jueves' )) ){
            return $next($request);
        }
        return redirect(route('home'));
    }
}
