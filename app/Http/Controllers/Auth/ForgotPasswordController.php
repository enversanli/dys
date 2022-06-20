<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgetPasswordRequest;
use App\Interfaces\AuthRepositoryInterface;

class ForgotPasswordController extends Controller
{
    /** @var AuthRepositoryInterface */
    protected $authRepository;

    public function __construct(AuthRepositoryInterface $authRepository){
        $this->authRepository = $authRepository;
    }

    public function update(ForgetPasswordRequest $request){

        $forgotPassword = $this->authRepository->forgotPassword($request);

        dd("asd");
    }
}
