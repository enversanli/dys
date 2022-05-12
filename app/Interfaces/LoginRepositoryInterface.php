<?php

namespace App\Interfaces;

use App\Http\Requests\Panel\LoginRequest;

interface LoginRepositoryInterface
{
    public function login(LoginRequest $request);
}
