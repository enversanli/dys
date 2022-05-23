<?php

namespace App\Interfaces;

use App\Http\Requests\Panel\RegisterRequest;
use App\Models\Association;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Http\Request;

interface UserRepositoryInterface
{

    public function storeUser(RegisterRequest $request, UserRole $userRole);
    public function getUsers(Request $request, Association $association);
    public function destroyStudent();

}
