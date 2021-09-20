<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogVerification extends Model
{
    use HasFactory;
    protected $table = 'log_verifications';
    protected $guarded = [];
}
