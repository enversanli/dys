<?php

namespace App\Interfaces;

use App\Support\Enums\UserRoleKeyEnum;
use App\Models\UserRole;

interface UserRoleRepositoryInterface
{
    public function getRoleByKey($key);
}
