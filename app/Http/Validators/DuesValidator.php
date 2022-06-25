<?php

namespace App\Http\Validators;

use App\Http\Requests\Panel\UpdateUserRequest;
use App\Interfaces\Validators\DuesValidatorInterface;
use App\Models\User;
use App\Models\Association;
use App\Models\StudentClass;
use App\Support\ResponseMessage;
use App\Support\Enums\UserStatusEnum;
use App\Support\Enums\UserRoleKeyEnum;
use App\Http\Requests\Panel\StoreUserRequest;
use App\Http\Requests\Panel\UpdateStudentRequest;
use App\Interfaces\Validators\UserValidatorInterface;
use Illuminate\Http\Request;

class DuesValidator implements DuesValidatorInterface
{
    public function index(User $user, User $authUser)
    {

        try {

            if (!$authUser->isAdmin() && $user->association_id != $authUser->association_id){
                return ResponseMessage::returnData(false, null, __('user.not_found'), 404);
            }

            if ($authUser->isParent() && $user->parent_id != $authUser->id){
                return ResponseMessage::returnData(false, null, __('user.not_found'), 404);
            }

            return ResponseMessage::returnData(true);
        }catch (\Exception $exception){

            return ResponseMessage::returnData(false);
        }
    }
}
