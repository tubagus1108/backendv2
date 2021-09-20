<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;
    protected $table = 'ppatk_prov';
    protected $guarded = [];
    public function contry_relation()
    {
        return $this->belongsTo(Country::class,'id_country','id');
    }
}
