<?php

namespace App\Http\Validators;

use App\Http\Requests\Panel\UpdateUserRequest;
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

class UserValidator implements UserValidatorInterface
{
    public function index(Request $request, User $user)
    {

        try {

            if ($user->isStudent()){
                return ResponseMessage::returnData(false, null, __('common.not_have_authority'), 401);
            }

            if ($user->isTeacher() && (
                $request->role == UserRoleKeyEnum::SUB_ASSOCIATION_MANAGER->value
                ||
                $request->role == UserRoleKeyEnum::ASSOCIATION_MANAGER->value
                ||
                $request->role == UserRoleKeyEnum::ADMIN->value
                )){
                return ResponseMessage::returnData(false, null, __('common.not_have_authority'), 401);
            }



            return ResponseMessage::returnData(true);
        }catch (\Exception $exception){

            return ResponseMessage::returnData(false);
        }
    }

    public function store(StoreUserRequest $request, User $user)
    {
        try {
            // If current user account is not activated yet.
            if ($user->status != UserStatusEnum::ACTIVE->value) {

                return ResponseMessage::returnData(false, null, __('common.not_activated'));
            }

            // Auth user's role check
            if ($user->role->key == UserRoleKeyEnum::STUDENT) {
                return ResponseMessage::returnData(false, null, __('common.not_have_authority'));
            }

            // check parent for student
            if ($request->role == UserRoleKeyEnum::STUDENT && !$request->has('parent_id')) {
                return ResponseMessage::returnData(false, null, __('user.parent_required'));
            }

            return ResponseMessage::returnData(true);
        } catch (\Exception $exception) {
            return ResponseMessage::returnData(false);
        }
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        try {
            // Get requested class
            $studentClass = $request->has('class_id') ? StudentClass::findOrFail($request->class_id) : null;
            if ($studentClass && $user->association->id != $studentClass->association_id) {
                return ResponseMessage::returnData(false, null, '');
            }


            return ResponseMessage::returnData(true);
        } catch (\Exception $exception) {
            return ResponseMessage::returnData(false);
        }
    }

    public function destroy(User $authUser, User $targetUser)
    {
        try {
            if ($authUser->association->id != $targetUser->association->id){
                return ResponseMessage::returnData(false, [], __('user.not_found'), 401);
            }

            if ($authUser->id == $targetUser->id){
                return ResponseMessage::returnData(false, [], __('user.canNotDeleteOwn'));
            }

            return ResponseMessage::returnData(true);
        } catch (\Exception $exception) {
            return ResponseMessage::returnData(false);
        }
    }
}
