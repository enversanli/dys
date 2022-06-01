<?php

namespace App\Models;

use App\Support\Enums\UserRoleKeyEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Association extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'creator_id',
        'key',
        'name',
        'status',
        'phone',
        'email',
    ];

    public function students(){
        return $this->hasMany(User::class, 'association_id', 'id')
            ->where('role_id', UserRole::where('key', UserRoleKeyEnum::STUDENT)->first()->id);
    }
}
