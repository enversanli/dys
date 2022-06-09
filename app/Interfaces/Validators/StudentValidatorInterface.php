<?php

namespace App\Interfaces\Validators;

use App\Models\User;
use App\Models\Association;
use App\Http\Requests\Panel\StoreStudentRequest;
use App\Http\Requests\Panel\UpdateStudentRequest;

interface StudentValidatorInterface
{
    public function store(StoreStudentRequest $request, User $association);
    public function update(UpdateStudentRequest $request, User $user);
    public function destroy(User $user, Association $association);
}
