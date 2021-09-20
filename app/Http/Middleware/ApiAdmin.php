<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ApiAdmin
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
        if(auth()->user()->type_user == 3 || auth()->user()->type_user == 4){
            return $next($request);
        }
        return response()->json(['error' => true, 'message' => 'You dont have admin access.']);
    }
}
