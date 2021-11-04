<?php

namespace App\Http\Controllers\WEB\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $users = User::where('type_user',1)->orWhere('type_user',2)->count();;
        return view('dashboard.index',compact('users'));
    }

}
