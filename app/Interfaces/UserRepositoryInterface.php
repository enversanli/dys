<?php

namespace App\Interfaces;

use App\Http\Requests\Panel\RegisterRequest;
use App\Http\Requests\Panel\StoreStudentRequest;
use App\Models\Association;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Http\Request;

interface UserRepositoryInterface
{

    public function storeStudent(StoreStudentRequest $request, Association $association);
    public function getStudentById($id);
    public function getStudents(Request $request, Association $association);
    public function getTotalStudents(Association $association, $status = null);
    public function destroyStudent(User $user);
    public function updateStudent(Request $request, User $user);

}
