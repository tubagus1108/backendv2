<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorKursManual extends Model
{
    use HasFactory;
    protected $table = 'vendor_kurs_manual';
    protected $guarded = [];
    public function currency_relation()
    {
        return $this->belongsTo(Currency::class,'id_currency','id');
    }
    public function currencyto_relation()
    {
        return $this->belongsTo(Currency::class,'id_currency_to','id');
    }
}
