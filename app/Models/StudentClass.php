<?php

namespace App\Models;

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
        'creator_id',
        'description',
        'association_id',
    ];

    public function association(){
        return $this->belongsTo(Association::class, 'association_id', 'id');
    }

    public function students(){
        return $this->hasMany(User::class, 'class_id', 'id');
    }
}
