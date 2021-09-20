<?php

namespace App\Http\Controllers\API\Currency;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CurrencyController extends Controller
{
    public function getCurrency()
    {
        $data = Currency::where('deleted_at',null)->get();
        if($data)
            return response()->json(['error' => false, 'message' => 'Success get currency!!', 'data' => $data],200);
        return response()->json(['error' => false, 'message' => 'Failed get currency!!'],400);
    }
    public function updateCurrency(Request $request, $id){
        $validated = Validator::make($request->all(),[
            'curr_code' => 'required',
            'negara' => 'required',
            'int_name' => 'required',
        ]);
        if($validated->fails())
        {
            return response()->json(['error' => true, 'message' => $validated->errors()],400);
        }
        $data = Currency::firstWhere('id', $id);
        if($data){
            $data = Currency::find($id);
            $data->curr_code = $request->curr_code;
            $data->negara = $request->negara;
            $data->int_name = $request->int_name;
            $data->save();
            return response()->json(['error' => false, 'message' => 'succes update data', 'data' => $data],200);
        } else {
            return response()->json(['error' => true, 'message' => 'NotFound data', 'data' => $data],404);
        }
    }
}
