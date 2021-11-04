<?php

namespace App\Http\Controllers\WEB\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function indexLogin()
    {
        if(Auth::check())
        {
            return redirect()->route('dashboard');
        }else{
            return view('auth.login');
        }
    }
    public function indexPost(Request $request)
    {
        if(!$request->all())
        {
            return view('auth.login');
        }
        else{
            $data = [
                'email' => $request->input('email'),
                'password' => $request->input('password'),
            ];
            Auth::attempt($data);
            if(Auth::check())
            {
                return redirect()->route('dashboard');
            }else{
                return redirect(route('login'))->with('failed' , 'Username Dan Password Salah' );
            }
        }
    }
    public function LogOut()
    {
        Session::flush();
        return redirect()->route('login');
    }
}
