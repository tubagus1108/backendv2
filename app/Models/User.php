<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    use HasApiTokens;
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'email',
        'password',
    ];
    protected $appends = [
        'date_birth_carbon',
    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'otp',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    // protected $appends = ['approve_admin_name'];
    public function admin_relation()
    {
        return $this->belongsTo(User::class,'admin_approve_1','id');
    }
    public function superadmin_relation()
    {
        return $this->belongsTo(User::class,'admin_approve_2','id');
    }
    // public function getApproveAdminNameAttribute(){
    //     return $this->admin_relation->gender;
    // }
    // public function getApproveSuperadminNameAttribute()
    // {
    //     return $this->superadmin_relation->first_name." ".$this->superadmin_relation->last_name;
    // }
    public function receipt_relation()
    {
        return $this->hasMany(Receipt::class,'user_id','id');
    }
    public function country_relation()
    {
        return $this->belongsTo(Country::class,'country_id','id');
    }
    public function province_relation()
    {
        return $this->belongsTo(Province::class,'province_id','id');
    }
    public function city_relation()
    {
        return $this->belongsTo(City::class,'city_id','id');
    }
    public function getDateBirthCarbonAttribute()
    {
        return Carbon::parse($this->date_birth)->format('Y-m-d');
    }
}
