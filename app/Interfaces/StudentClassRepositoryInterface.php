<?php

namespace App\Interfaces;

use App\Http\Requests\Panel\StudentClassStoreRequest;
use App\Models\Association;
use App\Models\StudentClass;
use App\Models\User;

interface StudentClassRepositoryInterface
{
    public function getStudentClassById($id, User $user);
    public function getTotalClasses(Association $association);
    public function destroyStudentClass(StudentClass $studentClass);
    public function getClasses(Association $association, $status = null);
    public function storeClass(StudentClassStoreRequest $request, Association $association);
}
