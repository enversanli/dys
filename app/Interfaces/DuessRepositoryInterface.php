<?php

namespace App\Interfaces;

use App\Http\Requests\Panel\StoreDuesRequest;
use App\Http\Requests\Panel\UpdateDuesRequest;
use App\Models\Dues;
use App\Models\User;
use Illuminate\Http\Request;

interface DuessRepositoryInterface
{
    public function getUserDuesses(Request $request, User $user);
    public function getDuesById($id, User $user = null);
    public function makeYearPeriod($dues, $year);
    public function store(StoreDuesRequest $request, User $user, User $authUser);
    public function update(UpdateDuesRequest $request, Dues $dues, User $authUser, User $user = null);
}
