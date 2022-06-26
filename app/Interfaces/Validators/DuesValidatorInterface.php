<?php

namespace App\Interfaces\Validators;

use App\Http\Requests\Panel\StoreDuesRequest;
use App\Http\Requests\Panel\UpdateUserRequest;
use App\Models\User;
use App\Http\Requests\Panel\StoreUserRequest;
use App\Http\Requests\Panel\UpdateStudentRequest;
use Illuminate\Http\Request;

interface DuesValidatorInterface
{
    public function index(User $user, User $authUser);
    public function storeDues(StoreDuesRequest $request, User $user);
}
