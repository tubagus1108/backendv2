<?php

namespace App\Models\MigrasiModel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MigrasiCurrency extends Model
{
    use HasFactory;
    protected $connection = 'mysql2';
    protected $table = "currency";
}
