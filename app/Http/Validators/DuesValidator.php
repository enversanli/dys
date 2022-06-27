<?php

namespace App\Http\Validators;

use App\Http\Requests\Panel\StoreDuesRequest;
use App\Http\Requests\Panel\UpdateUserRequest;
use App\Interfaces\Validators\DuesValidatorInterface;
use App\Models\User;
use App\Models\Association;
use App\Models\StudentClass;
use App\Support\Enums\DuesStatusEnum;
use App\Support\Enums\ErrorLogEnum;
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

            if (!$authUser->isAdmin() && $user->association_id != $authUser->association_id) {
                return ResponseMessage::returnData(false, null, __('user.not_found'), 404);
            }

            if ($authUser->isParent() && $user->parent_id != $authUser->id) {
                return ResponseMessage::returnData(false, null, __('user.not_found'), 404);
            }

            return ResponseMessage::returnData(true);
        } catch (\Exception $exception) {
            activity()
                ->withProperties(['error' => $exception->getMessage()])
                ->log(ErrorLogEnum::DUES_LIST_VALIDATOR_ERROR->value);
            return ResponseMessage::returnData(false);
        }
    }

    public function storeDues(StoreDuesRequest $request, User $user)
    {
        try {

            if (!$user->isStudent()){
                return ResponseMessage::returnData(false, null, __('dues.not_have_dues_payment'));
            }

            if ($request->year > now()->format('Y')){
                return ResponseMessage::returnData(false, null, __('dues.cannot_pay_next_year'));
            }

            $hasDues = $user->duesses()
                ->where('year', $request->year)
                ->where('month', $request->month)
                ->where('status', DuesStatusEnum::PAID->value)
                ->exists();

            if ($hasDues){
                return ResponseMessage::returnData(false, null, __('dues.already_paid'));
            }


            return ResponseMessage::returnData(true);
        }catch (\Exception $exception){

            activity()
                ->withProperties(['error' => $exception->getMessage()])
                ->log(ErrorLogEnum::STORE_DUES_VALIDATOR_ERROR->value);

            return ResponseMessage::returnData(false);
        }
    }

    public function updateDues(User $authUser){
        try {

            if (!$authUser->isManager() && !$authUser->isSubManager()){
                return ResponseMessage::returnData(false, null, __('common.not_have_authority'));
            }


            return ResponseMessage::returnData(true);
        }catch (\Exception $exception){

            activity()
                ->withProperties(['error' => $exception->getMessage()])
                ->log(ErrorLogEnum::UPDATE_DUES_VALIDATOR_ERROR->value);

            return ResponseMessage::returnData(false);
        }
    }
}
