<?php

namespace App\Interfaces;

use App\Http\Requests\Panel\StoreDuesRequest;
use App\Models\Dues;
use App\Models\User;
use Illuminate\Http\Request;

interface DuessRepositoryInterface
{
    public function getUserDuesses(Request $request, User $user);
    public function getDuesById($id, User $user = null);
    public function makeYearPeriod($dues, $year);
    public function store(StoreDuesRequest $request, User $user, User $authUser);
}
