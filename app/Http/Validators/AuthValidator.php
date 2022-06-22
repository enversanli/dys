<?php

namespace App\Http\Validators;

use App\Http\Requests\Auth\ForgetPasswordRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Http\Requests\Panel\UpdateUserRequest;
use App\Interfaces\Validators\AuthValidatorInterface;
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
use Illuminate\Support\Facades\Hash;

class AuthValidator implements AuthValidatorInterface
{
    public function resetPassword(ResetPasswordRequest $request)
    {
        $user = User::where('email', $request->email)->where('reset_password_code', $request->code)->first();
        try {
            if (!$user) {
                return ResponseMessage::returnData(false, null, __('common.not_found', ['param' => 'user.user']));
            }

            if ($user->status == UserStatusEnum::BANNED) {
                return ResponseMessage::returnData(false, null, __('user.banned'));
            }

            return ResponseMessage::returnData(true);
        } catch (\Exception $exception) {

            return ResponseMessage::returnData(false);
        }
    }

    public function forgotPassword(ForgetPasswordRequest $request)
    {

        try {
            $user = User::where('email', $request->email)->first();

            return ResponseMessage::returnData(true);
        } catch (\Exception $exception) {

            return ResponseMessage::returnData(false);
        }
    }

    public function verify(Request $request){
        try {

            $user = User::where('verification_code', $request->code)->first();

            if (!$user){
                return ResponseMessage::returnData(false, null, __('user.not_found'));
            }

            if ($user->email_verified_at && $user->status != UserStatusEnum::MAIL_VERIFICATION->value){
                return ResponseMessage::returnData(false, '', __('user.already_verified'));
            }

            return ResponseMessage::returnData(true);
        }catch (\Exception $exception){
            return ResponseMessage::returnData(false);
        }
    }
}
