<?php

namespace App\Repositories;

use App\Interfaces\UserRoleRepositoryInterface;
use App\Models\UserRole;
use App\Support\Enums\UserRoleKeyEnum;
use App\Support\ResponseMessage;

class UserRoleRepository implements UserRoleRepositoryInterface
{
    public function getRoleByKey($key){
        $role = UserRole::where('key', $key)->first();
        return ResponseMessage::returnData(true, $role);
    }

}
