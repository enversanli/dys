<?php

namespace App\Repositories;

use App\Http\Requests\Auth\ForgetPasswordRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Http\Requests\Panel\RegisterRequest;
use App\Interfaces\AssociationRepositoryInterface;
use App\Interfaces\AuthRepositoryInterface;
use App\Jobs\SendQueueEmailJob;
use App\Models\Association;
use App\Models\User;
use App\Support\DTOs\Emails\EmailDataDTO;
use App\Support\Enums\ErrorLogEnum;
use App\Support\Enums\UserRoleKeyEnum;
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

    public function register(RegisterRequest $request)
    {
        try {
            $data = [
              'first_name' => $request->first_name,
              'last_name' => $request->last_name
            ];

            return ResponseMessage::returnData(true);
        } catch (\Exception $exception) {

            return ResponseMessage::returnData(false);
        }
    }

    public function forgotPassword(ForgetPasswordRequest $request)
    {
        $user = $this->model->where('email', $request->email)->firstOrFail();
        try {
            $user->update([
                'reset_password_code' => Hash::make(Str::random(16)),
                'status' => UserStatusEnum::FORGOT_PASSWORD
            ]);

            $resetPasswordUrl = route('password.reset') . '?code=' . $user->reset_password_code;

            $mailData = new EmailDataDTO();
            $mailData->email = $user->email;
            $mailData->view ='mails.auth.forgot-password';
            $mailData->subject = __('auth.forgotPassword');
            $mailData->data = ['user' => $user, 'resetPasswordUrl' => $resetPasswordUrl];

            SendQueueEmailJob::dispatch($mailData);

            return ResponseMessage::returnData(true);
        } catch (\Exception $exception) {
            activity()
                ->withProperties(['error' => $exception->getMessage()])
                ->log(ErrorLogEnum::FORGOT_PASSWORD_AUTH_REPOSITORY_ERROR->value);

            return ResponseMessage::returnData(false);
        }
    }

    public function resetPassword(ResetPasswordRequest $request)
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

    public function verify(Request $request){
        try {
            $user = $this->model->where('verification_code', $request->code)->first();

            $data = [
                'email_verified_at' => now()->format('Y-m-d H:i:s'),
                'status' => UserStatusEnum::ACTIVE
            ];

            if ($user->role->key == UserRoleKeyEnum::STUDENT){
                $data['status'] = UserStatusEnum::TEACHER_CONFIRMATION->value;
            }

            $user->update($data);

            return ResponseMessage::returnData(true);
        }catch (\Exception $exception){
            dd($exception->getMessage());
            return ResponseMessage::returnData(false);
        }
    }
}
