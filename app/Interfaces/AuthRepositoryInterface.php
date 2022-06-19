<?php

namespace App\Interfaces;

use App\Models\User;
use Illuminate\Http\Request;

interface AuthRepositoryInterface
{
    public function register(Request $request);
    public function forgotPassword(Request $request);
    public function resetPassword(Request $request);
}
