<?php

namespace App\Http\Validators;

use App\Models\User;
use App\Models\StudentClass;
use App\Support\ResponseMessage;
use App\Support\Enums\UserRoleKeyEnum;
use App\Interfaces\Validators\StudentClassValidatorInterface;

class StudentClassValidator implements StudentClassValidatorInterface
{
    public function __construct(){

    }

    public function store()
    {
        // TODO: Implement store() method.
    }

    public function destroy(StudentClass $studentClass, User $user){

        try {
            if ($user->association->id != $studentClass->association_id){
                return ResponseMessage::returnData(false, __('common.not_found', ['param' => __('studentClass.class')]));
            }

            if ($user->role->key != UserRoleKeyEnum::ADMIN){
                return ResponseMessage::returnData(false, null, __('common.not_have_authority'), 401);
            }


        }catch (\Exception $exception){
            return ResponseMessage::returnData(false);
        }

    }

}
