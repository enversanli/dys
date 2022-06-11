<?php

namespace App\Interfaces\Validators;

use App\Http\Requests\Panel\UpdateStudentClassRequest;
use App\Models\User;
use App\Models\StudentClass;

interface StudentClassValidatorInterface
{
    public function store();
    public function update(StudentClass $studentClass, User $user);
    public function destroy(StudentClass $studentClass, User $user);
}
