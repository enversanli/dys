<?php

namespace App\Http\Validators\Student;

use App\Models\User;
use App\Models\Association;
use App\Models\StudentClass;
use App\Support\ResponseMessage;
use Illuminate\Http\Client\Request;
use App\Support\Enums\UserStatusEnum;
use App\Support\Enums\UserRoleKeyEnum;
use App\Http\Requests\Panel\StoreStudentRequest;
use App\Http\Requests\Panel\UpdateStudentRequest;
use App\Interfaces\Validators\StudentValidatorInterface;

class StudentValidator implements StudentValidatorInterface
{
    public function store(StoreStudentRequest $request, User $user){
        try {
            // If current user account is not activated yet.
            if ($user->status != UserStatusEnum::ACTIVE){
                return ResponseMessage::returnData(false, null, __('common.not_activated'));
            }

           if ($user->role->key == UserRoleKeyEnum::STUDENT){
               return ResponseMessage::returnData(false, null, __('common.not_have_authority'));
           }

            return ResponseMessage::returnData(true);
        }catch (\Exception $exception){
            return ResponseMessage::returnData(false);
        }
    }

    public function update(UpdateStudentRequest $request, User $student){
        try {
            // Get requested class
            $studentClass = $request->has('class_id') ? StudentClass::findOrFail($request->class_id) : null;
            if ($studentClass && $student->association->id != $studentClass->association_id){
                return ResponseMessage::returnData(false, null, '');
            }


            return ResponseMessage::returnData(true);
        }catch (\Exception $exception){
            return ResponseMessage::returnData(false);
        }
    }

    public function destroy(User $student, Association $association)
    {
        try {

            $situation = $association->whereHas('users', function ($query) use ($student){
                return $query->where('id', $student->id);
            })->exists();

            if (!$situation){
                return ResponseMessage::returnData(false, null, __('user.not_found'));
            }

            return ResponseMessage::returnData(true);
        }catch (\Exception $exception){

            return ResponseMessage::returnData(false);
        }
    }
}
