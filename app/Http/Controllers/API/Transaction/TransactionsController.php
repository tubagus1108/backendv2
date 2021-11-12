<?php

namespace App\Http\Controllers\API\Transaction;

use App\Http\Controllers\Controller;
use App\Mail\PaidMail;
use App\Mail\TransactionWaiting;
use App\Models\LogTrx;
use App\Models\Receipt;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Voucher;
use Carbon\Carbon;
use Exception;
use Facade\FlareClient\Flare;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class TransactionsController extends Controller
{
    public function addTransaction(Request $request)
    {
        $validated = Validator::make($request->all(),[
            'first_name' => 'required',
            'last_name' => 'required',
            'recipient_type' => 'in:1,2',
        ]);
        if($validated->fails())
        {
            return response()->json(['error' => true,'message' => $validated->errors()],400);
        }
        $data = User::where('id',Auth::guard('api-user')->user()->id)->get();
        // return $data[0]->id;
        if(!$data)
        {
            return response()->json(['error' =>true, 'message' => 'User not Found'],400);
        }
        if($data[0]->approve_1 == 'Approve' && $data[0]->approve_2 == 'Approve')
        {
        if($request->recipient_type == 2)
        {
            $create_new_receipt = Receipt::create([
                'id_group' => $request->id_group,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'type_receipt' => $request->type_receipt,
                'vendor_id' => $request->vendor_id,
                'service' => $request->service,
                'acc_number' => $request->acc_number,
                'id_type' => $request->id_type,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'id_number' => $request->id_number,
                'country' => $request->country,
                'bank_name' => $request->bank_name,
                'province_receipt' => $request->province_receipt,
                'address' => $request->address,
                'zip_code' => $request->zip_code,
                'user_id' => $data[0]->id,
                'status' => $request->status,
                'additional_info' => $request->additional_info,
                'branch' => $request->branch,
                'transit_code' => $request->transit_code,
                'sort_code' => $request->sort_code,
                'swift' => $request->swift,
                'bsb_code' => $request->bsb_code,
                'ifsc' => $request->ifsc,
                'routing_number' => $request->routing_number,
                'iban' => $request->iban,
                'account_type' => $request->account_type,
                'city' => $request->city,
                'postalcode' => $request->postalcode,
                'region' => $request->region,
                'bank_add' => $request->bank_add,
                'list_bank_id' => $request->list_bank_id,
            ]);
            $acc_name_new = ucwords($create_new_receipt->first_name . " " . $create_new_receipt->last_name);
        }else{
            $check_receipt = Receipt::where('id',$request->rec_id)->get();
            $acc_name_ready = ucwords($check_receipt[0]->first_name . " " . $check_receipt[0]->last_name);
        }
        $check_receipt_new = Receipt::where('id',$create_new_receipt->id)->with('vendor_relation')->get();
        // $check_voucher_where = Voucher::firstWhere('id',$request->voucher_id);
        // if($check_voucher_where->type == NULL)
        // {
        //     $check_voucher = Voucher::find($request->voucher_id);
        //     $check_voucher->code_voucher = $check_voucher_where->code_voucher;
        //     $check_voucher->value = $check_voucher_where->value;
        //     $check_voucher->status = 1;
        //     $check_voucher->type = 1;
        //     $check_voucher->user_id = Auth::guard('api-user')->user()->id;
        //     $check_voucher->created_at = Carbon::now('Asia/Jakarta');
        //     $check_voucher->save();
        // }else{
        //     Voucher::updated([
        //         'status' => 1,
        //     ]);
        // }
        $status_trx = "Waiting for Payment";
        $status_trx_admin = "Pending";
        $transaction = new Transaction();
        $transaction->invoice_num = $request->invoice_num;
        if($request->recipient_type == 2)
        {
            $transaction->rec_id = $create_new_receipt->id;
        }else{
            $transaction->rec_id = $check_receipt[0]->id;
        }
        $transaction->customer_rate = $request->customer_rate;
        $transaction->fee = $request->fee;
        $transaction->status = $request->status;
        $transaction->status_trx = $status_trx;
        $transaction->status_trx_admin = $status_trx_admin;
        $transaction->remarks_admin = $request->remarks_admin;
        $transaction->status_order = $status_trx_admin;
        $transaction->remarks_order = $request->remarks_order;
        $transaction->status_paid = $request->status_paid;
        $transaction->recipient_gets = $request->recipient_gets;
        $transaction->send = $request->send;
        $transaction->vendor_name = $request->vendor_name;
        $transaction->vendor_rate = $request->vendor_rate;
        $transaction->vendor_fee = $request->vendor_fee;
        $transaction->status_vendor = $request->status_vendor;
        $transaction->bank_id = $request->bank_id;
        $transaction->countdown_date = Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s');
        // $transaction->voucher_id = (isset($request->svoucher_id)) ? $check_voucher->id : 0;
        $transaction->user_id = $data[0]->id;
        $transaction->approve_at_1 = Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s');
        $transaction->approve_at_2 = Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s');
        $transaction->service = $request->service;
        $transaction->save();

        $url = $_ENV['URL_FRONTEND'];
        $voucherValue = (isset($check_voucher_where)) ? $check_voucher_where->value : 0;
        $details = [
            'name' => ucwords($request->first_name . " " . $request->last_name),
            'total_transaction' => number_format($transaction->send + $transaction->fee - $voucherValue,3),
            'receive' => (isset($request->recipient_gets)) ? $request->recipient_gets : '',
            'currency_code' => (isset($check_receipt_new[0]->currency)) ? $check_receipt_new[0]->currency : '',
            'name_receive' => (isset($acc_name_new)) ? $acc_name_new : $acc_name_ready,
            'customer_rate' => (isset($transaction->customer_rate)) ? $transaction->customer_rate : '0',
            'time' => (isset($transaction->countdown_date)) ? $transaction->countdown_date : '',
            'link' => $url,
            'id_transaction' => $transaction->id,
        ];
        Mail::to($data[0]->email)->send(new TransactionWaiting($details));
        if($transaction)
            return response()->json(['error' => false,'message' => 'success create transaction','data' => $transaction],200);
        return response()->json(['error' => true,'message' => 'failed create transaction','data' => $transaction],400);
        }else{
            return response()->json(['error' => false,'message' =>'Your account can`t make transactions, don`t forget to verify your data'],400);
        }
    }
    public function getAllTrasaction()
    {
        $data = Transaction::where('deleted_at',null)->where('service','<>','Bank Deposit')->with('receipt_relation','users_relation','bank_relation','voucher_relation')->orderBy('id_transaction','DESC')->get();
        if($data)
            return response()->json(['error' => false,'message' => 'success get transaction','data' => $data],200);
        return response()->json(['error' => true,'message' => 'failed get transaction'],400);
    }
    public function getAllTrasaction2()
    {
        $data = Transaction::where('deleted_at',null)->where('status_order','Pending')->where('status_trx','Payment Approved')->with('receipt_relation','users_relation','bank_relation','voucher_relation')->orderBy('id','DESC')->get();
            return response()->json(['error' => false, 'message' => 'Success get data transaction!!!', 'data' => $data],200);
        return response()->json(['error' => true, 'message' => 'Failed get data transaction!!'],400);
    }
    public function getAllIdTransaction($id)
    {
        $data = Transaction::find($id);
            return response()->json(['error' => false, 'message' => 'Success get data transaction!!!', 'data' => $data],200);
        return response()->json(['error' => true, 'message' => 'Failed get data transaction!!'],400);
    }
    public function getAllTrasactionTable($start_date,$end_date)
    {
        $data = Transaction::with('receipt_relation','users_relation','bank_relation','voucher_relation')->whereBetween('created_at',[$start_date.' 00:00:00',$end_date.' 23:59:59'])->get();
        if($data)
            return response()->json(['error' => false, 'message' => 'Success get data transaction!!!', 'data' => $data],200);
        return response()->json(['error' => true, 'message' => 'Failed get data transaction!!'],400);
    }
    public function getAllTrasactionComplit()
    {
        $data = Transaction::where('status_trx','Transaction Completed')->orWhere('status_trx','Payment Approved')->orWhere('status_trx','Transaction Processing')->orWhere('status_trx','Order Cancelled')->orderBy('id','DESC')->with('receipt_relation','users_relation','bank_relation','voucher_relation')->get();
            return response()->json(['error' => false, 'message' => 'Success get data transaction!!!', 'data' => $data],200);
        return response()->json(['error' => true, 'message' => 'Failed get data transaction!!'],400);
    }
    public function getApproveadminDetail($id)
    {
        clearstatcache();
        $data = Transaction::select("*",DB::raw('(CASE WHEN transactions.status_approve_1 = "0" THEN "Pending" WHEN transactions.status_approve_1 = "1" THEN "Approved" ELSE "Reject" END) AS status_approve_1,(CASE WHEN transactions.status_approve_2 = "1" THEN "Pending" WHEN transactions.status_approve_2 = "0" THEN "Approved" ELSE "Reject" END) AS status_approve_2'))->where('transactions.id',$id)->with('receipt_relation','users_relation','bank_relation','voucher_relation')->get();
        if($data)
            return response()->json(['error' =>false,'message' => 'Success get data approve admindetail','data' => $data],200);
        return response()->json(['error' =>true,'message' => 'failed get data approve admindetail','data' => $data],400);
        // return $data;
    }
    public function getApproveadmin($start_date,$end_date)
    {
        clearstatcache();
        $data = Transaction::select("*",DB::raw('(CASE WHEN transactions.status_approve_1 = "0" THEN "Pending" WHEN transactions.status_approve_1 = "1" THEN "Approved" ELSE "Reject" END) AS status_approve_1,(CASE WHEN transactions.status_approve_2 = "1" THEN "Pending" WHEN transactions.status_approve_2 = "0" THEN "Approved" ELSE "Reject" END) AS status_approve_2'))->whereBetween('created_at',[$start_date.' 00:00:00',$end_date.' 23:59:59'])->with('receipt_relation','users_relation','bank_relation','voucher_relation')->get();
        if($data)
            return response()->json(['error' =>false,'message' => 'Success get data approve admindetail','data' => $data],200);
        return response()->json(['error' =>true,'message' => 'failed get data approve admindetail','data' => $data],400);
    }
    public function getApprovesuperadmin($start_date,$end_date)
    {
        clearstatcache();
        $data = Transaction::select("*",DB::raw('(CASE WHEN transactions.status_approve_1 = "0" THEN "Pending" WHEN transactions.status_approve_1 = "1" THEN "Approved" ELSE "Reject" END) AS status_approve_1,(CASE WHEN transactions.status_approve_2 = "1" THEN "Pending" WHEN transactions.status_approve_2 = "0" THEN "Approved" ELSE "Reject" END) AS status_approve_2'))->whereBetween('created_at',[$start_date.' 00:00:00',$end_date.' 23:59:59'])->with('receipt_relation','users_relation','bank_relation','voucher_relation')->get();
        if($data)
            return response()->json(['error' =>false,'message' => 'Success get data approve admindetail','data' => $data],200);
        return response()->json(['error' =>true,'message' => 'failed get data approve admindetail','data' => $data],400);
    }
    public function reportTransaction($start_date,$end_date)
    {
        $data = Transaction::where('deleted_at',null)->where('status_approve_1',1)->orWhere('status_approve_1',1)->orWhere('status_approve_2',1)->where('status_trx_admin','Payment Approved')->orWhere('status_trx','Payment Rejected')->whereBetween('created_at',[$start_date.' 00:00:00',$end_date.' 23:59:59'])->with('receipt_relation','users_relation','bank_relation','voucher_relation')->get();
        if($data)
            return response()->json(['error' =>false,'message' => 'Success get data report','data' => $data],200);
        return response()->json(['error' =>true,'message' => 'failed get data report','data' => $data],400);
    }
    public function havePaid(Request $request,$id)
    {
        // $validated = Validator::make($request->all(),[
        //     'status_trx' => 'required',
        //     'status_trx_admin' => 'required',
        //     'status_paid' => 'required',
        // ]);
        // if($validated->fails()){
        //     return response()->json(['error' => true,'message' => $validated->errors()],400);
        // }
        $status_trx = "Waiting for Payment Confirmation";
        $status_trx_admin = "Pending";
        $status_trans = 'Paid';
        $update_time = Carbon::now('Asia/Jakarta');
        $data = Transaction::with('receipt_relation','users_relation','voucher_relation')->firstWhere('id',$id);
        // return $data;
        // return ucwords($data->receipt_relation->first_name. " " . $data->receipt_relation->last_name);
        $voucherValue = $data->voucher_relation->value;
        $currency_receipt =  $data->receipt_relation->currency_to;
        $name_receipt = ucwords($data->receipt_relation->first_name. " " . $data->receipt_relation->last_name);
        if($data)
        {
            $data = Transaction::find($id);
            $data->status_trx = $status_trx;
            $data->status_trx_admin = $status_trx_admin;
            $data->status_paid = $status_trans;
            $data->updated_at = $update_time;
            $activity_paid = "User click have paid status change to - " . $status_trx;
            $data->save();
            $url = $_ENV['URL_FRONTEND'];
            $details = [
                'name' => ucwords($request->first_name . " " . $request->last_name),
                'total_transaction' => number_format($data->send + $data->fee - $voucherValue,3),
                'receive' => (isset($request->recipient_gets)) ? $request->recipient_gets : '',
                'currency_code' => (isset($currency_receipt)) ? $currency_receipt : '',
                'name_receive' => (isset($name_receipt)) ? $name_receipt : $name_receipt,
                'customer_rate' => (isset($data->customer_rate)) ? $data->customer_rate : '0',
                'time' => (isset($data->countdown_date)) ? $data->countdown_date : '',
                'link' => $url,
                'id_transaction' =>$data->id,
            ];
            Mail::to($data->users_relation->email)->send(new PaidMail($details));
            try{
                LogTrx::create([
                    'activity' => $activity_paid,
                    'trx_id' => $data->id,
                    'user_id' => $data->users_relation->id,
                ]);
            }catch(Exception $e)
            {
                return response()->json(['error' => true,'message' => $e],400);
            }
            return response()->json(['error' => false, 'message' => 'succes have paid transaction', 'data' => $data],200);
        }else{
            return response()->json(['error' => true, 'message' => 'NotFound data', 'data' => $data],404);
        }
    }
    public function approveAdmin(Request $request,$id)
    {
        $data_admin = User::where('id',Auth::guard('admin-api')->user()->id)->get();
        // return $data_admin[0]->type_user;
        // if($data_admin[0]->type_user != 3){
        //     return response()->json(['error' => true,'message' => ''])
        // }
        $approve_status = $request->approve_status;
        if($approve_status == 1 && $data_admin[0]->type_user == 3)
        {
            $status_trx = "Payment Approved";
            $status_trx_admin = "Payment Approved";
        }else if($approve_status == 1 && $data_admin[0]->type_user == 4)
        {
            $status_trx = "Waiting for Payment Confirmation";
            $status_trx_admin = "Pending";
        }else{
            $status_trx = "Payment Rejected";
            $status_trx_admin = null;
        }
        $data = Transaction::with('receipt_relation','users_relation','voucher_relation')->firstWhere('id',$id);
        if($data)
        {
            $data = Transaction::find($id);
            $data->status_trx = $status_trx;
            $data->status_trx_admin = $status_trx_admin;
            $data->remarks_admin = $request->remarks_admin;
            $data->approve_user_1 = $data_admin[0]->id;
            $data->approve_at_1 = Carbon::now('Asia/Jakarta');
            $data->status_approve_1 = $approve_status;
            $data->updated_at = Carbon::now('Asia/Jakarta');
            $activity_trxt = "Remarks - " . $request->remarks;
            $data->save();
            try{
                LogTrx::create([
                    'activity' => $activity_trxt,
                    'trx_id' => $data->id,
                    'user_id' => $data->users_relation->id,
                ]);
            }catch(Exception $e)
            {
                return response()->json(['error' => true,'message' => $e],400);
            }
            return response()->json(['error' => false, 'message' => 'succes approve admin transaction', 'data' => $data],200);
        }else{
            return response()->json(['error' => true, 'message' => 'NotFound data', 'data' => $data],404);
        }
    }
    public function approveSuperAdmin(Request $request,$id)
    {
        $data_admin = User::where('id',Auth::guard('admin-api')->user()->id)->get();
        $approve_status = $request->approve_status;
        if($approve_status == 1)
        {
            $status_trx = "Payment Approved";
        }else{
            $status_trx = "Payment Rejected";
        }
        $data = Transaction::with('receipt_relation','users_relation','voucher_relation')->firstWhere('id',$id);
        if($data)
        {
            $data = Transaction::find($id);
            $data->status_trx = $status_trx;
            $data->status_trx_admin = $status_trx;
            $data->remarks_admin = $request->remarks_admin;
            $data->approve_user_2 = $data_admin[0]->id;
            $data->approve_at_2 = Carbon::now('Asia/Jakarta');
            $data->status_approve_2 = $approve_status;
            $data->updated_at = Carbon::now('Asia/Jakarta');
            $activity_trxt = "Remarks - " . $request->remarks;
            $data->save();
            try{
                LogTrx::create([
                    'activity' => $status_trx,
                    'trx_id' => $data->id,
                    'user_id' => $data->users_relation->id,
                ]);
            }catch(Exception $e)
            {
                return response()->json(['error' => true,'message' => $e],400);
            }
            return response()->json(['error' => false, 'message' => 'succes approve admin transaction', 'data' => $data],200);
        }else{
            return response()->json(['error' => true, 'message' => 'NotFound data', 'data' => $data],404);
        }
    }
    public function reportOrder($start_date,$end_date)
    {
        $data = Transaction::where('deleted_at',null)->where('status_approve_1',1)->where('status_approve_2',1)->where('status_order','Complete')->orWhere('status_order','Cancelled')->whereBetween('created_at',[$start_date.' 00:00:00',$end_date.' 23:59:59'])->with('receipt_relation','users_relation','bank_relation','voucher_relation')->get();
        if($data)
            return response()->json(['error' =>false,'message' => 'Success get data report','data' => $data],200);
        return response()->json(['error' =>true,'message' => 'failed get data report','data' => $data],400);
    }
    public function getOrder($start_date,$end_date)
    {
        $data = Transaction::where('deleted_at',null)->where('status_approve_1',1)->where('status_approve_2',2)->whereBetween('created_at',[$start_date.' 00:00:00',$end_date.' 23:59:59'])->with('receipt_relation','users_relation','bank_relation','voucher_relation')->get();
        if($data)
            return response()->json(['error' =>false,'message' => 'Success get data order','data' => $data],200);
        return response()->json(['error' =>true,'message' => 'failed get data order','data' => $data],400);
    }
}
