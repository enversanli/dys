<?php

namespace App\Interfaces\Validators;

use App\Http\Requests\Panel\UpdateUserRequest;
use App\Models\User;
use App\Http\Requests\Panel\StoreUserRequest;
use App\Http\Requests\Panel\UpdateStudentRequest;
use Illuminate\Http\Request;

interface UserValidatorInterface
{
    public function index(Request $request, User $user);
    public function store(StoreUserRequest $request, User $user);
    public function update(UpdateUserRequest $request, User $user);
    public function destroy(User $user, User $targetUser);
}
