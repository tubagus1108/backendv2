<?php

namespace App\Http\Controllers\WEB\Transactions;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class TransactionsController extends Controller
{
    public function TransactionsSuccess()
    {
        return view('transactions.success-transactions');
    }
    public function TransactionsPending()
    {
        return view('transactions.pending-transactions');
    }
    public function TransactionsAll()
    {
        return view('transactions.all-transactions');
    }
    public function DetailTransactions($id)
    {
        $data = Transaction::with(array('admin_relation' => function($query){
            $query->select('id',DB::raw("CONCAT(first_name,' ',last_name) as approve_admin_name"));
        }))->with(array('superadmin_relation' => function($query){
            $query->select('id',DB::raw("CONCAT(first_name,' ',last_name) as approve_super_admin_name"));
        }))->with('receipt_relation','users_relation','bank_relation','voucher_relation')->find($id);
        // return $data;
        return view('transactions.detail-transactions',compact('data'));
    }
    public function pendingDatatableAdmin()
    {
        $data =  clearstatcache();
        $data = Transaction::where('status_approve_1',0)->with('receipt_relation','users_relation','bank_relation','voucher_relation')->get();
        return DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('datetransaction',function($data){
            return Carbon::parse($data['created_at'])->format('F d, y');
        })
        ->addColumn('sender',function($data){
            return $data['users_relation']->first_name.' '.$data['users_relation']->last_name;
        })
        ->addColumn('recipient',function($data){
            return $data['receipt_relation']->first_name.' '.$data['receipt_relation']->last_name;
        })
        ->addColumn('totalsend',function($data){
            $conver_double = $data['recipient_gets'];
            $view_convert = number_format((float)$conver_double,2,'.','');
            return $data['receipt_relation']->currency_to.' '.$view_convert;
        })
        ->addColumn('acc_number',function($data){
            return $data['receipt_relation']->acc_number;
        })
        ->addColumn('bank_name',function($data){
            return $data['receipt_relation']->bank_name;
        })
        ->addColumn('rate',function($data){
            $conver_rate = $data['customer_rate'];
            $view_covert_rate = number_format($conver_rate);
            return $view_covert_rate;
        })
        ->addColumn('fee',function($data){
            $conver_double_rupiah = $data['fee'];
            $view_convert_rupiah = number_format($conver_double_rupiah);
            return $data['receipt_relation']->currency.' '.$view_convert_rupiah;
        })
        ->addColumn('voucher',function($data){
            if($data['voucher_relation'] == null)
            {
                return $data['receipt_relation']->currency.' '.'0';
            }
            else{
                $conver_double_rupiah = $data['voucher_relation']->value;
                $view_convert_rupiah = number_format($conver_double_rupiah);
                return $data['receipt_relation']->currency.' '.$view_convert_rupiah;
            }
        })
        ->addColumn('totalpay',function($data){
            $conver_double_rupiah = $data['send'];
            $view_convert_rupiah = number_format($conver_double_rupiah);
            return $data['receipt_relation']->currency.' '.$view_convert_rupiah;
        })
        ->addColumn('ihavepaid',function($data){
            if($data['status_trx'] == 'Waiting for Payment')
            {
                return '<button class="btn btn-pill btn-danger active" type="button" title="btn btn-pill btn-danger">NO</button>';
            }else{
                return '<button class="btn btn-pill btn-success active" type="button" title="btn btn-pill btn-danger">YES</button>';
            }
        })
        ->addColumn('approveButton',function($data){
            // $edit = '<a href="'.url('transactions/'.$data['id'].'/approve-transactions').'" class="btn btn-success" role="button">Approve</a>';
            $approve = "'".url('transactions/'.$data['id'].'/approve-transactions')."'";
            $edit = '<button value="Approve" onclick ="document.location.href='.$approve.'" class="btn btn-success p-2" > <i class="fa fa-check"></i> </button>';
            return $edit;
        })
        ->rawColumns(['ihavepaid','approveButton'])
        ->make(true);
    }
    public function pendingDatatableSuperadmin()
    {
        clearstatcache();
        $data = Transaction::where('status_approve_1','<>',0)->with(array('admin_relation' => function($query){
            $query->select('id',DB::raw("CONCAT(first_name,' ',last_name) as approve_admin_name"));
        }))->where('status_trx','<>','Payment Approved')->where('status_trx_admin','<>','Payment Approved')->with('receipt_relation','users_relation','bank_relation','voucher_relation')->get();
        // return $data;
        return DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('datetransaction',function($data){
            return Carbon::parse($data['created_at'])->format('F d, y');
        })
        ->addColumn('sender',function($data){
            return $data['users_relation']->first_name.' '.$data['users_relation']->last_name;
        })
        ->addColumn('recipient',function($data){
            return $data['receipt_relation']->first_name.' '.$data['receipt_relation']->last_name;
        })
        ->addColumn('totalsend',function($data){
            $conver_double = $data['recipient_gets'];
            $view_convert = number_format((float)$conver_double,2,'.','');
            return $data['receipt_relation']->currency_to.' '.$view_convert;
        })
        ->addColumn('acc_number',function($data){
            return $data['receipt_relation']->acc_number;
        })
        ->addColumn('bank_name',function($data){
            return $data['receipt_relation']->bank_name;
        })
        ->addColumn('rate',function($data){
            $conver_rate = $data['customer_rate'];
            $view_covert_rate = number_format($conver_rate);
            return $view_covert_rate;
        })
        ->addColumn('fee',function($data){
            $conver_double_rupiah = $data['fee'];
            $view_convert_rupiah = number_format($conver_double_rupiah);
            return $data['receipt_relation']->currency.' '.$view_convert_rupiah;
        })
        ->addColumn('voucher',function($data){
            if($data['voucher_relation'] == null)
            {
                return $data['receipt_relation']->currency.' '.'0';
            }
            else{
                $conver_double_rupiah = $data['voucher_relation']->value;
                $view_convert_rupiah = number_format($conver_double_rupiah);
                return $data['receipt_relation']->currency.' '.$view_convert_rupiah;
            }
        })
        ->addColumn('totalpay',function($data){
            $conver_double_rupiah = $data['send'];
            $view_convert_rupiah = number_format($conver_double_rupiah);
            return $data['receipt_relation']->currency.' '.$view_convert_rupiah;
        })
        ->addColumn('adminapprove',function($data){
            return $data['admin_relation']->approve_admin_name;
        })
        ->addColumn('statusapprove',function($data){
            if($data['status_approve_2'] == 0)
            {
                return '<button class="btn btn-pill btn-danger active" type="button" title="btn btn-pill btn-danger">Pending</button>';
            }else{
                return '<button class="btn btn-pill btn-success active" type="button" title="btn btn-pill btn-danger">Approve</button>';
            }
        })
        ->addColumn('approveButton',function($data){
            // $edit = '<a href="'.url('transactions/'.$data['id'].'/approve-transactions').'" class="btn btn-success" role="button">Approve</a>';
            $approve = "'".url('transactions/'.$data['id'].'/approve-transactions')."'";
            $edit = '<button value="Approve" onclick ="document.location.href='.$approve.'" class="btn btn-success p-2" > <i class="fa fa-check"></i> </button>';
            return $edit;
        })
        ->rawColumns(['statusapprove','approveButton'])
        ->make(true);
    }
    public function successatatableAdmin()
    {
        $data =  clearstatcache();
        $data = Transaction::where('status_trx','Payment Approved')->with('receipt_relation','users_relation','bank_relation','voucher_relation')->get();
        return DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('datetransaction',function($data){
            return Carbon::parse($data['created_at'])->format('F d, y');
        })
        ->addColumn('sender',function($data){
            return $data['users_relation']->first_name.' '.$data['users_relation']->last_name;
        })
        ->addColumn('recipient',function($data){
            return $data['receipt_relation']->first_name.' '.$data['receipt_relation']->last_name;
        })
        ->addColumn('totalsend',function($data){
            $conver_double = $data['recipient_gets'];
            $view_convert = number_format((float)$conver_double,2,'.','');
            return $data['receipt_relation']->currency_to.' '.$view_convert;
        })
        ->addColumn('acc_number',function($data){
            return $data['receipt_relation']->acc_number;
        })
        ->addColumn('bank_name',function($data){
            return $data['receipt_relation']->bank_name;
        })
        ->addColumn('rate',function($data){
            $conver_rate = $data['customer_rate'];
            $view_covert_rate = number_format($conver_rate);
            return $view_covert_rate;
        })
        ->addColumn('fee',function($data){
            $conver_double_rupiah = $data['fee'];
            $view_convert_rupiah = number_format($conver_double_rupiah);
            return $data['receipt_relation']->currency.' '.$view_convert_rupiah;
        })
        ->addColumn('voucher',function($data){
            if($data['voucher_relation'] == null)
            {
                return $data['receipt_relation']->currency.' '.'0';
            }
            else{
                $conver_double_rupiah = $data['voucher_relation']->value;
                $view_convert_rupiah = number_format($conver_double_rupiah);
                return $data['receipt_relation']->currency.' '.$view_convert_rupiah;
            }
        })
        ->addColumn('totalpay',function($data){
            $conver_double_rupiah = $data['send'];
            $view_convert_rupiah = number_format($conver_double_rupiah);
            return $data['receipt_relation']->currency.' '.$view_convert_rupiah;
        })
        ->addColumn('ihavepaid',function($data){
            if($data['status_trx'] == 'Waiting for Payment')
            {
                return '<button class="btn btn-pill btn-danger active" type="button" title="btn btn-pill btn-danger">NO</button>';
            }else{
                return '<button class="btn btn-pill btn-success active" type="button" title="btn btn-pill btn-danger">YES</button>';
            }
        })
        ->addColumn('approveButton',function($data){
            // $edit = '<a href="'.url('transactions/'.$data['id'].'/approve-transactions').'" class="btn btn-success" role="button">Approve</a>';
            $approve = "'".url('transactions/'.$data['id'].'/approve-transactions')."'";
            $edit = '<button value="Approve" onclick ="document.location.href='.$approve.'" class="btn btn-success p-2" > <i class="fa fa-check"></i> </button>';
            return $edit;
        })
        ->rawColumns(['ihavepaid','approveButton'])
        ->make(true);
    }
    public function successDatatableSuperadmin()
    {
        clearstatcache();
        $data = Transaction::where('status_tryx','Payment Approved')->with(array('admin_relation' => function($query){
            $query->select('id',DB::raw("CONCAT(first_name,' ',last_name) as approve_admin_name"));
        }))->where('status_trx','<>','Payment Approved')->where('status_trx_admin','<>','Payment Approved')->with('receipt_relation','users_relation','bank_relation','voucher_relation')->get();
        // return $data;
        return DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('datetransaction',function($data){
            return Carbon::parse($data['created_at'])->format('F d, y');
        })
        ->addColumn('sender',function($data){
            return $data['users_relation']->first_name.' '.$data['users_relation']->last_name;
        })
        ->addColumn('recipient',function($data){
            return $data['receipt_relation']->first_name.' '.$data['receipt_relation']->last_name;
        })
        ->addColumn('totalsend',function($data){
            $conver_double = $data['recipient_gets'];
            $view_convert = number_format((float)$conver_double,2,'.','');
            return $data['receipt_relation']->currency_to.' '.$view_convert;
        })
        ->addColumn('acc_number',function($data){
            return $data['receipt_relation']->acc_number;
        })
        ->addColumn('bank_name',function($data){
            return $data['receipt_relation']->bank_name;
        })
        ->addColumn('rate',function($data){
            $conver_rate = $data['customer_rate'];
            $view_covert_rate = number_format($conver_rate);
            return $view_covert_rate;
        })
        ->addColumn('fee',function($data){
            $conver_double_rupiah = $data['fee'];
            $view_convert_rupiah = number_format($conver_double_rupiah);
            return $data['receipt_relation']->currency.' '.$view_convert_rupiah;
        })
        ->addColumn('voucher',function($data){
            if($data['voucher_relation'] == null)
            {
                return $data['receipt_relation']->currency.' '.'0';
            }
            else{
                $conver_double_rupiah = $data['voucher_relation']->value;
                $view_convert_rupiah = number_format($conver_double_rupiah);
                return $data['receipt_relation']->currency.' '.$view_convert_rupiah;
            }
        })
        ->addColumn('totalpay',function($data){
            $conver_double_rupiah = $data['send'];
            $view_convert_rupiah = number_format($conver_double_rupiah);
            return $data['receipt_relation']->currency.' '.$view_convert_rupiah;
        })
        ->addColumn('adminapprove',function($data){
            return $data['admin_relation']->approve_admin_name;
        })
        ->addColumn('statusapprove',function($data){
            if($data['status_approve_2'] == 0)
            {
                return '<button class="btn btn-pill btn-danger active" type="button" title="btn btn-pill btn-danger">Pending</button>';
            }else{
                return '<button class="btn btn-pill btn-success active" type="button" title="btn btn-pill btn-danger">Approve</button>';
            }
        })
        ->addColumn('approveButton',function($data){
            // $edit = '<a href="'.url('transactions/'.$data['id'].'/approve-transactions').'" class="btn btn-success" role="button">Approve</a>';
            $approve = "'".url('transactions/'.$data['id'].'/approve-transactions')."'";
            $edit = '<button value="Approve" onclick ="document.location.href='.$approve.'" class="btn btn-success p-2" > <i class="fa fa-check"></i> </button>';
            return $edit;
        })
        ->rawColumns(['statusapprove','approveButton'])
        ->make(true);
    }
    public function ApproveTransaction(Request $request,$id)
    {
        if(Auth::user()->type_user == 4)
        {
            Transaction::where('id',$id)->update([
                'status_approve_1' => 1,
                'approve_user_1' => Auth::user()->id,
                'updated_at' => Carbon::now('Asia/Jakarta'),
            ]);
            return redirect()->route('transactions-pending');
        }else{
            Transaction::where('id',$id)->update([
                'status_trx' => 'Payment Approved',
                'status_trx_admin' => 'Payment Approved',
                'status_approve_2' => 1,
                'approve_user_2' => Auth::user()->id,
                'updated_at' => Carbon::now('Asia/Jakarta'),
            ]);
            return redirect()->route('transactions-pending');
        }
    }
    public function ListDatatableTransaction()
    {
        $data = Transaction::all();
        // return $data;
        return DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('datetransaction',function($data){
            return Carbon::parse($data['created_at'])->format('F d, y');
        })
        ->addColumn('sender',function($data){
            return $data['users_relation']->first_name.' '.$data['users_relation']->last_name;
        })
        ->addColumn('recipient',function($data){
            return $data['receipt_relation']->first_name.' '.$data['receipt_relation']->last_name;
        })
        ->addColumn('totalsend',function($data){
            $conver_double = $data['recipient_gets'];
            $view_convert = number_format((float)$conver_double,2,'.','');
            return $data['receipt_relation']->currency_to.' '.$view_convert;
        })
        ->addColumn('country',function($data){
            return $data['receipt_relation']->country_to;
        })
        ->addColumn('bank_name',function($data){
            return $data['receipt_relation']->bank_name;
        })
        ->addColumn('rate',function($data){
            $conver_rate = $data['customer_rate'];
            $view_covert_rate = number_format($conver_rate);
            return $view_covert_rate;
        })
        ->addColumn('fee',function($data){
            $conver_double_rupiah = $data['fee'];
            $view_convert_rupiah = number_format($conver_double_rupiah);
            return $data['receipt_relation']->currency.' '.$view_convert_rupiah;
        })
        ->addColumn('voucher',function($data){
            if($data['voucher_relation'] == null)
            {
                return $data['receipt_relation']->currency.' '.'0';
            }
            else{
                $conver_double_rupiah = $data['voucher_relation']->value;
                $view_convert_rupiah = number_format($conver_double_rupiah);
                return $data['receipt_relation']->currency.' '.$view_convert_rupiah;
            }
        })
        ->addColumn('totalpay',function($data){
            $conver_double_rupiah = $data['send'];
            $view_convert_rupiah = number_format($conver_double_rupiah);
            return $data['receipt_relation']->currency.' '.$view_convert_rupiah;
        })
        ->addColumn('actions',function($data){
            $edit = '<a class="btn btn-primary" href="'.url('transactions/'.$data['id'].'/detail').'"> <i class="fa fa-edit"> </i> </a>';
            return $edit;
        })
        ->rawColumns(['ihavepaid','approveButton','actions'])
        ->make(true);
    }
}
