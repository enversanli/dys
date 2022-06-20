<?php

namespace App\Interfaces;

use Illuminate\Http\Request;
use App\Http\Requests\Auth\ForgetPasswordRequest;

interface AuthRepositoryInterface
{
    public function register(Request $request);
    public function forgotPassword(ForgetPasswordRequest $request);
    public function resetPassword(Request $request);
}
