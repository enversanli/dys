<?php

namespace App\Repositories;

use App\Http\Requests\Panel\LoginRequest;
use App\Interfaces\LoginRepositoryInterface;
use App\Models\User;
use App\Support\Enums\ErrorLogEnum;
use App\Support\ResponseMessage;
use Illuminate\Support\Facades\Auth;

class LoginRepository implements LoginRepositoryInterface
{
    public function login(LoginRequest $request)
    {
        try {

            /** User login control */
            if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                return ResponseMessage::returnData(false, [], __('auth.failed'));
            }
            $user = User::where('email', $request->email)->firstOrFail();

            //$token = $user->createToken('auth_token')->plainTextToken;

            $credentials = $request->only('email', 'password');

            if (!Auth::attempt($credentials)){
                return ResponseMessage::failed();
            }

            return ResponseMessage::returnData(true, ['token' => $token, 'user' => $user]);

        } catch (\Exception $exception) {

            activity()
                ->withProperties(['message' => $exception->getMessage()])
                ->log(ErrorLogEnum::LOGIN_REPOSITORY_ERROR->value);

            return ResponseMessage::failed();
        }

    }
}
