<?php

namespace App\Interfaces\Validators;

use App\Models\User;
use App\Models\Association;
use App\Http\Requests\Panel\StoreUserRequest;
use App\Http\Requests\Panel\UpdateStudentRequest;

interface UserValidatorInterface
{
    public function store(StoreUserRequest $request, User $association);
    public function update(UpdateStudentRequest $request, User $user);
    public function destroy(User $user, Association $association);
}
