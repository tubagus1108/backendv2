<?php

namespace App\Models\MigrasiModel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BiChecks extends Model
{
    use HasFactory;
    protected $connection = 'mysql2';
    protected $table = "bi_check";
}
