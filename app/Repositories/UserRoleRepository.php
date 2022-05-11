<?php

namespace App\Repositories;

use App\Interfaces\UserRoleRepositoryInterface;
use App\Models\UserRole;
use App\Support\Enums\UserRoleKeyEnum;

class UserRoleRepository implements UserRoleRepositoryInterface
{
    public function getRoleByKey($key){
        return UserRole::where('key', $key)->first();
    }

}
