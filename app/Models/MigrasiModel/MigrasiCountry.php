<?php

namespace App\Models\MigrasiModel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MigrasiCountry extends Model
{
    use HasFactory;
    protected $connection = 'mysql2';
    protected $table = "ppatk_country";
}
