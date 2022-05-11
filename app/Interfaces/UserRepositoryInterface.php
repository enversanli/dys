<?php

namespace App\Interfaces;

use App\Http\Requests\Panel\RegisterRequest;
use App\Models\UserRole;

interface UserRepositoryInterface
{
    public function getStudents();
    public function storeUser(RegisterRequest $request, UserRole $userRole);
    public function destroyStudent();

}
