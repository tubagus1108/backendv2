<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankList extends Model
{
    use HasFactory;
    protected $table = 'bank_list';
    protected $guarded = [];
    // protected $appends = ['currency'];
    public function currency_ralation()
    {
        return $this->belongsTo(Currency::class,'currency_id','id');
    }
    public function service_realation()
    {
        return $this->belongsTo(Service::class,'service_id','id');
    }

}
