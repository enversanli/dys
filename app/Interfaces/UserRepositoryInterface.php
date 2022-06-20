<?php

namespace App\Interfaces;

use App\Http\Requests\Panel\RegisterRequest;
use App\Http\Requests\Panel\StoreStudentRequest;
use App\Http\Requests\Panel\StoreUserRequest;
use App\Http\Requests\Panel\UpdateUserRequest;
use App\Models\Association;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Http\Request;

interface UserRepositoryInterface
{

    public function storeUser(StoreUserRequest $request, Association $association);
    public function getUserById($id);
    public function getUsers(Request $request, Association $association, User $authUser);
    public function getTotalUsers(Association $association, $status = null);
    public function destroyUser(User $user);
    public function updateUser(UpdateUserRequest $request, User $user);

}
