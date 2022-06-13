<?php

namespace App\Interfaces\Validators;

use App\Models\User;
use App\Models\Association;
use App\Http\Requests\Panel\StoreUserRequest;
use App\Http\Requests\Panel\UpdateStudentRequest;
use Illuminate\Http\Request;

interface UserValidatorInterface
{
    public function index(Request $request, User $association);
    public function store(StoreUserRequest $request, User $association);
    public function update(UpdateStudentRequest $request, User $user);
    public function destroy(User $user, Association $association);
}
