<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $table = 'transactions';
    protected $guarded = [];
    protected $appends = ['recipient_name','sender_name','currency'];
    public function receipt_relation()
    {
        return $this->belongsTo(Receipt::class,'rec_id','id');
    }
    public function users_relation()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
    public function getCurrencyAttribute()
    {
        $resault = "Currency Tidak ditemukan";
        if($this->receipt_relation){
            $tableVendorManual = VendorKurs::where('id',$this->receipt_relation->vendor_id)->first();
            $tableCurrency = Currency::where('id',$tableVendorManual->id)->first();
            $resault = $tableCurrency['curr_code'];
        }
        return $resault;
    }
    public function getRecipientNameAttribute()
    {
        return $this->receipt_relation->first_name." ". $this->receipt_relation->last_name;
    }
    public function getSenderNameAttribute()
    {
        return $this->users_relation->first_name." ". $this->users_relation->last_name;
    }
    public function bank_relation()
    {
        return $this->belongsTo(Bank::class,'bank_id','id');
    }
    public function voucher_relation()
    {
        return $this->belongsTo(Voucher::class,'voucher_id','id');
    }
}
