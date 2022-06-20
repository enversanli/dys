<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgetPasswordRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Interfaces\AuthRepositoryInterface;
use App\Interfaces\Validators\AuthValidatorInterface;
use App\Support\ResponseMessage;

class ForgotPasswordController extends Controller
{
    /** @var AuthRepositoryInterface */
    protected $authRepository;

    /** @var AuthValidatorInterface */
    protected $authValidator;

    public function __construct(AuthRepositoryInterface $authRepository, AuthValidatorInterface $authValidator){
        $this->authRepository = $authRepository;
        $this->authValidator = $authValidator;
    }

    public function update(ForgetPasswordRequest $request){

        $forgotPassword = $this->authRepository->forgotPassword($request);
        if (!$forgotPassword->status)
            return redirect()->back()->withErrors(['msh' => $forgotPassword->message]);

        return redirect()->route('auth.login');
    }

    public function resetPassword(ResetPasswordRequest $request){

        $validator = $this->authValidator->resetPassword($request);

        if (!$validator->status)
            return redirect()->back()->withErrors(['message' => $validator->message]);

        $resetPassword = $this->authRepository->resetPassword($request);

        if (!$resetPassword->status)
            return redirect()->back()->withErrors(['message' => $resetPassword->message]);

        return redirect()->route('auth.login');
    }
}
