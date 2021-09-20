<?php

namespace App\Http\Controllers\API\Vendor;

use App\Http\Controllers\Controller;
use App\Models\VendorKurs;
use App\Models\VendorKursManual;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VendorKursManualController extends Controller
{
    public function addVendorkurs(Request $request)
    {
        $validated = Validator::make($request->all(),[
            'vendor_name' => 'required',
            'buy' => 'required',
            'sell' => 'required',
            'customer_fee' => 'required',
        ]);
        if($validated->fails())
        {
            return response()->json(['error' => true,'message' => $validated->errors()],400);
        }
        $data = VendorKursManual::create($request->all());
        if($data)
            return response()->json(['error' => false,'message' => 'success create vendor manual','data'=> $data],200);
        return response()->json(['error' => true,'message' => 'failed create vendor manual'],400);
    }
    public function kursmanual()
    {
        $data = VendorKursManual::where('deleted_at',null)->with('currency_relation')->with('currencyto_relation')->get();
        if($data)
            return response()->json(['error' => false,'message' => 'success get data vendor manual','data' => $data],200);
        return response()->json(['error' => true,'message' => 'failed get data vendor manual'],400);
    }
}
