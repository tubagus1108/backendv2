<?php

namespace App\Http\Controllers\API\Transaction;

use App\Http\Controllers\Controller;
use App\Mail\TransactionWaiting;
use App\Models\Receipt;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Voucher;
use Carbon\Carbon;
use Exception;
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
        };
        $data = User::where('id',Auth::guard('api-user')->user()->id)->get();
        // return $data[0]->id;
        if(!$data)
        {
            return response()->json(['error' =>true, 'message' => 'User not Found'],400);
        }

        if($request->recipient_type == 2)
        {
            $create_new_receipt = Receipt::create([
                'id_group' => $request->id_group,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'type_receipt' => $request->type_receipt,
                'vendor_manual_id' => $request->vendor_manual_id,
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
            ]);
            $acc_name_new = ucwords($create_new_receipt->first_name . " " . $create_new_receipt->last_name);
        }else{
            $check_receipt = Receipt::where('id',$request->rec_id)->get();
            $acc_name_ready = ucwords($check_receipt[0]->first_name . " " . $check_receipt[0]->last_name);
        }
        $check_receipt_new = Receipt::where('id',$create_new_receipt->id)->with('vendor_relation')->get();
        $check_voucher_where = Voucher::firstWhere('id',$request->voucher_id);
        if($check_voucher_where->type == NULL)
        {
            $check_voucher = Voucher::find($request->voucher_id);
            $check_voucher->code_voucher = $check_voucher_where->code_voucher;
            $check_voucher->value = $check_voucher_where->value;
            $check_voucher->status = 1;
            $check_voucher->type = 1;
            $check_voucher->user_id = Auth::guard('api-user')->user()->id;
            $check_voucher->created_at = Carbon::now('Asia/Jakarta');
            $check_voucher->save();
        }else{
            Voucher::updated([
                'status' => 1,
            ]);
        }
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
        $transaction->status_order = $request->status_order;
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
        $transaction->voucher_id = (isset($request->voucher_id)) ? $check_voucher->id : 0;
        $transaction->user_id = $data[0]->id;
        $transaction->approve_at_1 = Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s');
        $transaction->approve_at_2 = Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s');
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

    }


}