<?php

namespace App\Http\Controllers\API\Voucher;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Voucher;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class VoucherController extends Controller
{
    public function create_voucher(Request $request)
    {
        $validated = Validator::make($request->all(),[
            'value' => 'required',
            'code_voucher' => 'required'
        ]);
        if($validated->fails()){
            return response()->json(['error' => true, 'message' => $validated->errors()],400);
        }
        $data = User::where('id',Auth::guard('admin-api')->user()->id)->where('type_user', 3)->get();
        if(!$data)
            return response()->json(['error' => true, 'message' => 'User not Found!!']);
        try{
            DB::transaction(function () use ($data,$request) {
                Voucher::create([
                    'code_voucher' => $request->code_voucher,
                    'user_id' =>$data[0]->id,
                    'value' => $request->value,
                    'status' => 0,
                ]);
            });
        }catch(Exception $e)
        {
            return response()->json(['error' => true, 'message' => $e],400);
        }
        return response()->json(['error' => false, 'message' => 'Voucher successfully created'],200);
    }
    public function delete_voucher($id){
        $data = Voucher::find($id);
        // dd($data);
        if($data->delete())
            return response()->json(['error' => false, 'message' => 'Successfully delete voucher!!'],200);
        return response()->json(['error' => true, 'message' => 'Failed to delete voucher!!'],400);
    }
    public function retrieve_voucher(Request $request,$start_date,$end_date)
    {
        $data = Voucher::whereBetween('created_at',[$start_date.' 00:00:00',$end_date.' 23:59:59'])->get();
        if($data)
            return response()->json(['error' => true, 'message' => 'Failed get data voucher!!'],400);
        return response()->json(['error' => false, 'message' => 'Success get data voucher!!!', 'data' => $data],200);
    }
}
