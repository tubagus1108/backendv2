<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorKurs extends Model
{
    use HasFactory;
    protected $table = 'vendor_kurs';
    protected $guarded = [];
}
