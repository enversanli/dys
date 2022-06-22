<?php

namespace App\Interfaces;

use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Http\Requests\Panel\RegisterRequest;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\ForgetPasswordRequest;

interface AuthRepositoryInterface
{
    public function register(RegisterRequest $request);
    public function forgotPassword(ForgetPasswordRequest $request);
    public function resetPassword(ResetPasswordRequest $request);
}
