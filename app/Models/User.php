<?php

namespace App\Models;

use App\Support\Enums\UserRoleKeyEnum;
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
        'phone',
        'email',
        'gender',
        'status',
        'role_id',
        'password',
        'parent_id',
        'class_id',
        'last_name',
        'photo_url',
        'time_zone',
        'first_name',
        'birth_date',
        'mobile_phone',
        'association_id',
        'verification_code',
        'email_verified_at',
        'reset_password_code',
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     * Get User's role
     */
    public function role(){
        return $this->hasOne(UserRole::class, 'id', 'role_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     * Get User's association
     */
    public function association(){
        return $this->hasOne(Association::class, 'id', 'association_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     * Get user's class
     */
    public function class(){
        return $this->hasOne(StudentClass::class, 'id', 'class_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * If user is user, get it's parent account.
     */
    public function parent(){
        return $this->belongsTo(User::class, 'parent_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     * Returns users for parent account
     */
    public function students(){
        return $this->hasMany(User::class, 'parent_id', 'id');
    }

    public function duesses(){
        return $this->hasMany(Dues::class, 'user_id', 'id');
    }

    /** FUNCTIONS */

    /**
     * Is Student account or not
     */
    public function isStudent(){
        return $this->role->key == UserRoleKeyEnum::STUDENT->value ? true : false;
    }

    /**
     * Is Parent account or not
     */
    public function isParent(){
        return $this->role->key == UserRoleKeyEnum::PARENT->value ? true : false;
    }

    /**
     * Is Admin account or not
     */
    public function isAdmin(){
        return $this->role->key == UserRoleKeyEnum::ADMIN->value ? true : false;
    }


    /**
     * Is Teacher account or not
     */
    public function isTeacher(){
        return $this->role->key == UserRoleKeyEnum::TEACHER->value ? true : false;
    }

    /**
     * Is Manager account or not
     */
    public function isManager(){
        return $this->role->key == UserRoleKeyEnum::ASSOCIATION_MANAGER->value ? true : false;
    }

    /**
     * Is Sub Manager account or not
     */
    public function isSubManager(){
        return $this->role->key == UserRoleKeyEnum::ASSOCIATION_MANAGER->value ? true : false;
    }

}
