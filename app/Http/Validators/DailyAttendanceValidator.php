<?php

namespace App\Http\Validators;

use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Interfaces\Validators\DailyAttendanceValidatorInterface;
use App\Models\User;
use App\Support\ResponseMessage;
use Illuminate\Http\Request;

class DailyAttendanceValidator implements DailyAttendanceValidatorInterface
{
    public function getStudentAttendances(Request $request, User $user)
    {
        try {


            return ResponseMessage::returnData(true);
        }catch (\Exception $exception){

            return ResponseMessage::returnData(false);
        }
    }
}
