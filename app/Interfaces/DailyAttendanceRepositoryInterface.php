<?php

namespace App\Interfaces;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\Panel\StoreDailyAttendanceRequest;

interface DailyAttendanceRepositoryInterface
{
        public function get(Request $request, User $user);

        public function store(StoreDailyAttendanceRequest $request, User $authUser);
}
