<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WebHandle
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(!Auth::check())
        {
            return redirect()->route('login');
        }else{
            if(auth()->user()->type_user == 3 || auth()->user()->type_user == 4)
            {
                return $next($request);
            }
            return redirect('login')->with('error','User Not Access');
        }
    }
}
