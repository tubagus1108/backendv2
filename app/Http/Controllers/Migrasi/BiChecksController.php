<?php

namespace App\Http\Controllers\Migrasi;

use App\Http\Controllers\Controller;
use App\Models\BiCheck;
use App\Models\MigrasiModel\BiChecks;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BiChecksController extends Controller
{
    public function __construct()
    {
        set_time_limit(800000000000000000);
    }
    public function migrasiBiCheck(){
        $oldBicheck = BiChecks::all();
        foreach($oldBicheck as $item)
        {
            $exist = BiCheck::where('nama', $item->nama)->first();
            if(!$exist)
                BiCheck::create(['nama' => $item->nama,'deskripsi' => $item->deskripsi,'terduga' => $item->terduga, 'kode_densus' => $item->kode_densus, 'tempat_lahir'=> $item->tempat_lahir, 'tgl_lahir' => $item->tgl_lahir, 'warga_negara' => $item->warga_negara, 'alamat' => $item->alamat]);
        }
        return response()->json(['error' => false, 'message' => 'Migrate Success']);
    }
}
