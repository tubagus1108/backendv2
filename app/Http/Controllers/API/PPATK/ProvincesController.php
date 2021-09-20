<?php

namespace App\Http\Controllers\API\PPATK;

use App\Http\Controllers\Controller;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProvincesController extends Controller
{
    public function getProvince()
    {
        $data = Province::where('deleted_at',null)->with('contry_relation')->get();
        if($data)
            return response()->json(['error' => false,'message' => 'success get province','data'=>$data],200);
        return response()->json(['error' => true,'message' => 'failed get data provice'],400);
    }
    public function addProv(Request $request)
    {
        $validated = Validator::make($request->all(),[
            'kode_prov' => 'required',
            'nama_province' =>'required',
        ]);
        if($validated->fails()){
            return response()->json(['error' =>true,'message' => $validated->errors()],400);
        }
        $data = Province::create($request->all());
        if($data)
            return response()->json(['error' => false,'message' => 'success add province','data' => $data],200);
        return response()->json(['error' => true,'message' => 'failed add province'],400);
    }
    public function getSpesificProv($id_country)
    {
        $data = Province::where('deleted_at',null)->where('id_country',$id_country)->with('contry_relation')->get();
        if($data)
            return response()->json(['error' => false,'message' => 'success get spesifikasi province','data'=> $data],200);
        return response()->json(['error' => true,'message'=>'failed get spesifikasi province'],400);
    }
    public function update_province(Request $request,$id)
    {
        $validated = Validator::make($request->all(),[
            'kode_prov' => 'required',
            'nama_province'=> 'required',
        ]);
        if($validated->fails())
        {
            return response()->json(['error' => true,'message'=> $validated->errors()],400);
        }
        $data = Province::firstWhere('id',$id);
        if($data)
        {
            $data = Province::find($id);
            $data->kode_prov = $request->kode_prov;
            $data->id_country = $request->id_country;
            $data->nama_province = $request->nama_province;
            $data->save();
            return response()->json(['error' => false,'message' => 'succes update province','data'=> $data],200);
        }else{
            return response()->json(['error' => true,'message' => 'failed update province'],400);
        }
    }
}
