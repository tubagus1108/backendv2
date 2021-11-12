<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $table = 'transactions';
    protected $guarded = [];
    protected $appends = ['recipient_name','sender_name','transaction_date_carbon','approve_admin_date_carbon','approve_superadmin_date_carbon'];
    public function receipt_relation()
    {
        return $this->belongsTo(Receipt::class,'rec_id','id');
    }
    public function users_relation()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
    // public function getCurrencyAttribute()
    // {
    //     $resault = "Currency Tidak ditemukan";
    //     if($this->receipt_relation){
    //         $tableVendorManual = VendorKurs::where('id',$this->receipt_relation->vendor_id)->first();
    //         $tableCurrency = Currency::where('id',$tableVendorManual->id)->first();
    //         $resault = $tableCurrency['curr_code'];
    //     }
    //     return $resault;
    // }
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
    public function admin_relation()
    {
        return $this->belongsTo(User::class,'approve_user_1','id');
    }
    public function superadmin_relation()
    {
        return $this->belongsTo(User::class,'approve_user_2','id');
    }
    public function getTransactionDateCarbonAttribute()
    {
        return Carbon::parse($this->created_at)->format('Y-m-d h:i:s');
    }
    public function getApproveAdminDateCarbonAttribute()
    {
        return Carbon::parse($this->approve_at_1)->format('Y-m-d h:i:s');
    }
    public function getApproveSuperAdminDateCarbonAttribute()
    {
        return Carbon::parse($this->approve_at_2)->format('Y-m-d h:i:s');
    }
}
