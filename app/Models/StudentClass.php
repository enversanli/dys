<?php

namespace App\Models;

use App\Support\Enums\UserRoleKeyEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentClass extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'key',
        'name',
        'teacher_id',
        'creator_id',
        'description',
        'association_id',
    ];

    public function association(){
        return $this->belongsTo(Association::class, 'association_id', 'id');
    }

    public function students(){
        return $this->hasMany(User::class, 'class_id', 'id')->where('role_id',
        UserRole::where('key', UserRoleKeyEnum::STUDENT)->first()->id
        );
    }

    public function teacher(){
        return $this->hasOne(User::class, 'id', 'teacher_id');
    }

    public function creator(){
        return $this->hasOne(User::class, 'id', 'creator_id');
    }
}
