<?php

namespace App\Http\Controllers\WEB\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $users = User::where('type_user',1)->orWhere('type_user',2)->where('user_status','Verification passed')->count();
        $pending_register = User::where('user_status','Waiting for Verification')->count();
        $success_transactions = Transaction::where('status_trx','Payment Approved')->count();
        $pending_transactions = Transaction::where('status_trx','Waiting for Payment')->orWhere('status_trx','Waiting for Payment Confirmation')->count();
        $pending_vendor = Transaction::where('status_trx','Payment Approved')->where('status_trx_admin','Payment Approved')->count();
        return view('dashboard.index',compact('users','pending_register','success_transactions','pending_transactions','pending_vendor'));
    }

}
