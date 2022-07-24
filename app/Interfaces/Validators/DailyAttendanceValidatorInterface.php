<?php

namespace App\Interfaces\Validators;

use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Models\User;
use Illuminate\Http\Request;

interface DailyAttendanceValidatorInterface
{
    public function getAttendances(Request $request, User $user);
}
