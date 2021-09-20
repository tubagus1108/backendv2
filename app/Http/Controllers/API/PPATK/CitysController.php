<?php

namespace App\Http\Controllers\API\PPATK;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CitysController extends Controller
{
    public function getCity()
    {
        $data = City::where('deleted_at',null)->get();
        if($data)
            return response()->json(['error' => false,'message' => 'success get city','data' => $data],200);
        return response()->json(['error' => true,'message' => 'failed get city'],400);
    }
    public function addCity(Request $request)
    {
        $validated = Validator::make($request->all(),[
            'kode_city_ppatk' => $request->kode_city_ppatk,
            'kode_city_bi' => $request->kode_city_bi,
            'nama_city_bi' => $request->nama_city_bi,
            'nama_city_ppatk' => $request->nama_city_ppatk,
        ]);
        if($validated->fails())
        {
            return response()->json(['error' => true,'message' => $validated->errors()],400);
        }
        $data = City::create($request->all());
        if($data)
            return response()->json(['error' => false,'message' => 'success create city new','data' => $data],200);
        return response()->json(['error' => true,'message' => 'failed create city'],400);
    }
    public function getSpesificCity($id)
    {
        $data = City::find($id);
        if($data)
            return response()->json(['error' => false,'message' => 'success get city by id','data' => $data],200);
        return response()->json(['error' => true,'message' => 'failed get city by id'],400);
    }
    public function getCitybyProv($id_province)
    {
        $data = City::where('deleted_at',null)->where('id_province',$id_province)->get();
        if($data)
            return response()->json(['error' => false,'message' => 'success get city by id province','data' => $data],200);
        return response()->json(['error' => true,'message' => 'failed get city by id province'],400);
    }
}
