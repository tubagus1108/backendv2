<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    use HasFactory;
    protected $table = 'receipt';
    protected $guarded = [];
    public function vendor_relation()
    {
        return $this->belongsTo(VendorKursManual::class,'vendor_manual_id','id');
    }
}
