<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    use HasFactory;
    protected $table = 'receipt';
    protected $guarded = [];
    protected $appends = ['currency','currency_to'];

    public function vendor_relation()
    {
        return $this->belongsTo(VendorKursManual::class,'vendor_manual_id','id');
    }
    public function getCurrencyToAttribute()
    {
        $resault = "Currency tidak ditemukan";
        if($this->vendor_relation){
            $tableCurrencyGetData = Currency::where('id',$this->vendor_relation->id_currency_to)->first();
            $resault = $tableCurrencyGetData['curr_code'];
        }
        return $resault;
    }
    public function getCurrencyAttribute()
    {
        $resault = "Currency tidak ditemukan";
        if($this->vendor_relation){
            $tableCurrencyGetData = Currency::where('id',$this->vendor_relation->id_currency)->first();
            $resault = $tableCurrencyGetData['curr_code'];
        }
        return $resault;
    }
    public function users_relation()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
    public function bank_list_relation()
    {
        return $this->belongsTo(BankList::class,'list_bank_id','id');
    }

}
