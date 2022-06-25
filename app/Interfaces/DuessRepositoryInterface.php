<?php

namespace App\Interfaces;

use App\Models\Dues;
use App\Models\User;
use Illuminate\Http\Request;

interface DuessRepositoryInterface
{
    public function getUserDuesses(Request $request, User $user);
    public function makeYearPeriod($dues, $year);
}
