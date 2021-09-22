<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $table = 'transactions';
    protected $guarded = [];
    public function receipt_relation()
    {
        return $this->belongsTo(Receipt::class,'rec_id','id');
    }
    public function users_relation()
    {
        return $this->belongsTo(User::class,'user_id','id');
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
