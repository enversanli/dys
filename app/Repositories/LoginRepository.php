<?php

namespace App\Repositories;

use App\Http\Requests\Panel\LoginRequest;
use App\Interfaces\LoginRepositoryInterface;
use App\Support\ResponseMessage;
use Illuminate\Support\Facades\Auth;

class LoginRepository implements LoginRepositoryInterface
{
    public function login(LoginRequest $request)
    {
        /** User login control */
        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return ResponseMessage::returnData(false, [], __('auth.failed'));
        }
    }
}
