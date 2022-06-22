<?php

namespace App\Repositories;

use App\Interfaces\UserRoleRepositoryInterface;
use App\Models\UserRole;
use App\Support\Enums\ErrorLogEnum;
use App\Support\Enums\UserRoleKeyEnum;
use App\Support\ResponseMessage;

class UserRoleRepository implements UserRoleRepositoryInterface
{
    /** @var UserRole */
    public $model;

    public function __construct(UserRole $userRole)
    {
        $this->model = $userRole;
    }

    public function getRoleByKey($key){
        try {
            $role = $this->model->where('key', $key)->first();

            if (!$role)
                return ResponseMessage::returnData(false, null, __('userRole.not_found'));

            return ResponseMessage::returnData(true, $role);
        }catch (\Exception $exception){

            return ResponseMessage::returnData(false);
        }
    }

    public function getUserRoles()
    {
        try {
            $userRoles = $this->model->all();

            return ResponseMessage::returnData(true, $userRoles);
        }catch (\Exception $exception){

            activity()
                ->withProperties(['error' => $exception->getMessage()])
                ->log(ErrorLogEnum::GET_USER_ROLES_REPOSITORY_ERROR->value);

            return ResponseMessage::returnData(false);
        }
    }

}
