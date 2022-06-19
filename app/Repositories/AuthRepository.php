<?php

namespace App\Repositories;

use App\Interfaces\AssociationRepositoryInterface;
use App\Interfaces\AuthRepositoryInterface;
use App\Models\Association;
use App\Models\User;
use App\Support\Enums\ErrorLogEnum;
use App\Support\Enums\UserStatusEnum;
use App\Support\ResponseMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthRepository implements AuthRepositoryInterface
{
    /** @var User */
    private $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function register(Request $request)
    {
        try {


            return ResponseMessage::returnData(true);
        } catch (\Exception $exception) {

            return ResponseMessage::returnData(false);
        }
    }

    public function forgotPassword(Request $request)
    {
        $user = $this->model->where('email', $request->email)->firstOrFail();
        try {
            $user->update([
                'reset_password_code' => Str::random(16),
                'status' => UserStatusEnum::FORGOT_PASSWORD
            ]);

            return ResponseMessage::returnData(true);
        } catch (\Exception $exception) {
            activity()
                ->withProperties(['error' => $exception->getMessage()])
                ->log(ErrorLogEnum::FORGOT_PASSWORD_AUTH_REPOSITORY_ERROR->value);

            return ResponseMessage::returnData(false);
        }
    }

    public function resetPassword(Request $request)
    {
        $user = $this->model->where('email', $request->email)->firstOrFail();
        try {
            $user->update([
                'password' => Hash::make($request->password),
                'status' => UserStatusEnum::ACTIVE,
                'reset_password_code' => null,
            ]);

            return ResponseMessage::returnData(true);
        } catch (\Exception $exception) {
            activity()
                ->withProperties(['error' => $exception->getMessage()])
                ->log(ErrorLogEnum::RESET_PASSWORD_AUTH_REPOSITORY_ERROR->value);

            return ResponseMessage::returnData(false);
        }
    }
}
