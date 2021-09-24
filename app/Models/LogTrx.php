<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogTrx extends Model
{
    use HasFactory;
    protected $table = 'log_trx';
    protected $guarded = [];
}
