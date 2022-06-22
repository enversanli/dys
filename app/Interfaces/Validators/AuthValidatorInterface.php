<?php

namespace App\Interfaces\Validators;

use App\Http\Requests\Auth\ForgetPasswordRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Http\Requests\Panel\UpdateUserRequest;
use App\Models\User;
use App\Http\Requests\Panel\StoreUserRequest;
use App\Http\Requests\Panel\UpdateStudentRequest;
use Illuminate\Http\Request;

interface AuthValidatorInterface
{
    public function resetPassword(ResetPasswordRequest $request);

    public function forgotPassword(ForgetPasswordRequest $request);

    public function verify(Request $request);
}
