<?php

namespace App\Http\Controllers\WEB\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $users = User::where('type_user',1)->orWhere('type_user',2)->where('user_status','Verification passed')->count();
        $pending_register = User::where('user_status','Waiting for Verification')->count();
        $success_transactions = Transaction::where('status_trx','Payment Approved')->count();
        $pending_transactions = Transaction::where('status_trx','Waiting for Payment')->count();
        return view('dashboard.index',compact('users','pending_register','success_transactions'));
    }

}
