<?php

namespace App\Http\Controllers\API\Receipt;

use App\Http\Controllers\Controller;
use App\Models\Receipt;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ReciptsController extends Controller
{
    public function getReceipts()
    {
        $data = Receipt::where('deleted_at',null)->get();
        // dd($data);
        if($data)
            return response()->json(['error' => false, 'message' => 'sucess get data receipt!!', 'data' => $data],200);
        return response()->json(['error' => true, 'message' => 'failed get data receipt!!'],400);
    }
    public function getReceiptByUser($id)
    {
        $data = User::find($id);
        if(!$data)
            return response()->json(['error' => true, 'message' => 'User not Found'],400);
        $receipt = Receipt::where('user_id', $data->id)->get();
        if($receipt)
            return response()->json(['error' => false, 'message' => 'success full get dat receipt by user', 'data' => $receipt],200);
        return response()->json(['error' => false, 'message' => 'faield get dat receipt by user'],400);

    }
    public function create_recipts(Request $request){
        $validated = Validator::make($request->all(),[
            'first_name' => 'required',
            'last_name' => 'required',
            'des_country' => 'required',
        ]);
        if($validated->fails())
        {
            return response()->json([
                'error' => true,
                'message' => $validated->errors()
            ]);
        }
        $data = User::where('id',Auth::guard('api-user')->user()->id)->get();
        if(!$data)
        {
            return response()->json(['error' =>true, 'message' => 'User not Found'],400);
        }
        try{
            DB::transaction(function () use ($data, $request) {
                Receipt::create([
                    'id_group' => $request->id_group,
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'des_country' => $request->des_country,
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
            });
        }catch(Exception $e){
            return response()->json(['error' => true, 'message' => $e],400);
        }
        return response()->json(['error' => false, 'message' => 'Success full create receipt!!'],200);
    }
    public function create_recipts_admin(Request $request)
    {
        $validated = Validator::make($request->all(),[
            'first_name' => 'required',
            'last_name' => 'required',
            'des_country' => 'required',
        ]);
        if($validated->fails())
        {
            return response()->json([
                'error' => true,
                'message' => $validated->errors()
            ]);
        }
        try{
            DB::transaction(function () use ($request) {
                Receipt::create([
                    'id_group' => $request->id_group,
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'des_country' => $request->des_country,
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
                    'user_id' => $request->user_id,
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
            });
        }catch(Exception $e){
            return response()->json(['error' => true, 'message' => $e],400);
        }
        return response()->json(['error' => false, 'message' => 'Success full create receipt!!'],200);
    }
    public function getRecipientCountry($country)
    {
        $check_user = User::where('id',Auth::guard('api-user')->user()->id)->get();
        if(!$check_user)
        {
            return response()->json(['error' => true, 'message' => 'User not found!!'],400);
        }
        $data = Receipt::where('user_id',$check_user[0]->id)->where('des_country',$country)->get();
        if($data)
            return response()->json(['error' => false, 'message' => 'success get data receipt by country', 'data' => $data],200);
        return response()->json(['error' => true, 'message' => 'failed get data receipt by country'],400);
    }
    public function updateReceipt(Request $request,$id)
    {
        $validated = Validator::make($request->all(),[
            'first_name' => 'required',
            'last_name' => 'required',
            'des_country' => 'required',
        ]);
        if($validated->fails())
        {
            return response()->json(['error' => true, 'message' => $validated->errors()],400);
        }
        $data = Receipt::firstWhere('id', $id);
        if($data){
            $data = Receipt::find($id);
            $data->id_group = $request->id_group;
            $data->first_name = $request->first_name;
            $data->last_name = $request->last_name;
            $data->des_country = $request->des_country;
            $data->service = $request->service;
            $data->acc_number = $request->acc_number;
            $data->email = $request->email;
            $data->id_number = $request->id_number;
            $data->country = $request->country;
            $data->bank_name = $request->bank_name;
            $data->province_receipt = $request->province_receipt;
            $data->address = $request->address;
            $data->additional_info = $request->additional_info;
            $data->branch = $request->branch;
            $data->transit_code = $request->transit_code;
            $data->sort_code = $request->sort_code;
            $data->swift = $request->swift;
            $data->bsb_code = $request->bsb_code;
            $data->ifsc = $request->ifsc;
            $data->routing_number = $request->routing_number;
            $data->iban = $request->iban;
            $data->account_type = $request->account_type;
            $data->city = $request->city;
            $data->postalcode = $request->postalcode;
            $data->region = $request->region;
            $data->bank_add = $request->bank_add;
            $data->save();
            return response()->json(['error' => false, 'message' => 'succes update data', 'data' => $data],200);
        } else {
            return response()->json(['error' => false, 'message' => 'NotFound data', 'data' => $data],404);
        }
    }
}
