<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VendorKurs extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'vendor_kurs';
    protected $guarded = [];
    protected $dates = ['deleted_at'];
    public function currency_relation()
    {
        return $this->belongsTo(Currency::class,'id_currency','id');
    }
    public function currencyto_relation()
    {
        return $this->belongsTo(Currency::class,'id_currency_to','id');
    }
}
