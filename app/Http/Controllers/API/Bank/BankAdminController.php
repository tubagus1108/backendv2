<?php

namespace App\Http\Controllers\API\Bank;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\BankList;
use App\Models\Service;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BankAdminController extends Controller
{
    public function addBank(Request $request)
    {
        $validated = Validator::make($request->all(),[
            'bank_name' => 'required|max:255|regex:/^[a-zA-ZÑñ\s]+$/',
            'acc_name' => 'required',
            'no_rek' => 'required',
            'cab_bank' => 'required',
        ]);
        if($validated->fails())
        {
            return response()->json(['error' => true,'message' => $validated->errors()],400);
        }
        $data = User::where('id', Auth::guard('admin-api')->user()->id)->where('type_user',3)->get();
        if(!$data)
        {
            return response()->json(['error' => true, 'message' => 'User not found!!'],400);
        }
        try{
            DB::transaction(function () use ($data, $request) {
                Bank::create([
                    'bank_name' => $request->bank_name,
                    'acc_name' => $request->acc_name,
                    'no_rek' => $request->no_rek,
                    'cab_bank' => $request->cab_bank,
                    'user_id' => $data[0]->id,
                ]);
            });
        }catch(Exception $e)
        {
            return response()->json(['error' => true, 'message' => $e],400);
        }
        return response()->json(['error' => false, 'message' => 'Successfully created bank!!'],200);

    }
    public function getBank()
    {
        $data = Bank::where('deleted_at',null)->get();
        if($data)
            return response()->json(['error' => false, 'message' => 'Success get bank!!', 'data' => $data],200);
        return response()->json(['error' => true, 'message' => 'Failed get bank!!'],400);
    }
    public function updateBank(Request $request,$id)
    {
        $validated = Validator::make($request->all(),[
            'bank_name' => 'required',
            'acc_name' => 'required',
            'no_rek' => 'required',
            'cab_bank' => 'required',
        ]);
        if($validated->fails())
        {
            return response()->json(['error' => true, 'message' => $validated->errors()],400);
        }
        $data = Bank::firstWhere('id', $id);
        if($data){
            $data = Bank::find($id);
            $data->bank_name = $request->bank_name;
            $data->acc_name = $request->acc_name;
            $data->no_rek = $request->no_rek;
            $data->cab_bank = $request->cab_bank;
            $data->save();
            return response()->json(['error' => false, 'message' => 'succes update data', 'data' => $data],200);
        } else {
            return response()->json(['error' => false, 'message' => 'NotFound data', 'data' => $data],404);
        }

    }
    public function deleteBank($id)
    {
        $data = Bank::find($id);
        if($data->delete())
            return response()->json(['error' => false, 'message' => 'Success delete data bank!!', 'data' => $data],200);
        return response()->json(['error' => true, 'message' => 'Failed delete data bank!!'],400);
    }
    public function getBankID($id)
    {
        $data = Bank::find($id);
        if($data)
            return response()->json(['error' => false, 'message' => 'Success get data bank!!', 'data' => $data],200);
        return response()->json(['error' => true, 'message' => 'Failed get data bank!!'],400);
    }
    public function addService(Request $request)
    {
        $validated = Validator::make($request->all(),[
            'name' => 'required',
        ]);
        if($validated->fails()){
            return response()->json(['error'=> true,'message' => $validated->errors()],400);
        }
        $data = Service::create($request->all());
        if($data)
            return response()->json(['error' => false,'message' => 'success service','data' => $data],200);
    }
    public function getBankList()
    {
        $data = BankList::where('deleted_at',null)->with('currency_ralation','service_realation')->get();
        return $data;
    }
}
