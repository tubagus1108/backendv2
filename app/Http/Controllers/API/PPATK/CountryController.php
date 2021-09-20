<?php

namespace App\Http\Controllers\API\PPATK;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CountryController extends Controller
{
    public function getCountries()
    {
        $data = Country::where('deleted_at',null)->get();
        // return $data;
        if($data)
            return response()->json(['error' => false,'message' =>'success get data country!!', 'data' => $data],200);
        return response()->json(['error' => true,'message' =>'failed get data country!!'],400);
    }
    public function create_country(Request $request)
    {
        $validated = Validator::make($request->all(),[
            'kode_negara' => 'required',
            'negara' => 'required',
        ]);
        if($validated->fails())
        {
            return response()->json(['error' => true, 'message' => $validated->errors()],400);
        }
        $data = Country::create($request->all());
        if($data)
            return response()->json(['error' => false,'message' => 'Success create country!!',],200);
        return response()->json(['error' => true,'message' => 'Failed create country!!',],400);
    }
    public function getSpesificCountry($id)
    {
        $data = Country::find($id);
        if($data)
            return response()->json(['error' => false,'message' => 'success get spesifikasi country', 'data' => $data],200);
        return response()->json(['error' => true,'message' => 'failed get spesifikasi country'],400);
    }
    public function updateCountry(Request $request,$id)
    {
        $validated = Validator::make($request->all(),[
            'kode_negara' => 'required',
            'negara' => 'required',
        ]);
        if($validated->fails())
        {
            return response()->json(['error' => true,'message' => $validated->errors()],400);
        }
        $data = Country::firstWhere('id',$id);
        if($data)
        {
            $data = Country::find($id);
            $data->kode_negara = $request->kode_negara;
            $data->negara = $request->negara;
            $data->save();
            return response()->json(['error' => false,'message'=> 'success update data country', 'data' => $data],200);
        }else{
            return response()->json(['error' => true,'message'=>'failed update data country!!'],400);
        }
    }
}
