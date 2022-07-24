<?php

namespace App\Interfaces\Validators;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\Panel\StoreDailyAttendanceRequest;

interface DailyAttendanceValidatorInterface
{
    public function getAttendances(Request $request, User $authUser);
    public function storeAttendance(StoreDailyAttendanceRequest $request, User $authUser);
}
