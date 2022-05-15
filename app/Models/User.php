<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Model implements Authenticatable
{
    use HasFactory, \Illuminate\Auth\Authenticatable, HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'key',
        'role_id',
        'association_id',
        'paren_id',
        'class_id',
        'first_name',
        'last_name',
        'mobile_phone',
        'phone',
        'email',
        'password',
        'email_verified_at',
        'reset_password_code',
        'status',
        'photo_url',
        'birth_date',
        'time_zone',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'birth_date' => 'datetime',
    ];

    public function role(){
        return $this->hasOne(UserRole::class, 'id', 'role_id');
    }

    public function association(){
        return $this->hasOne(Association::class, 'id', 'association_id');
    }
}
