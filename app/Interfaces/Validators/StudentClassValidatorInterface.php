<?php

namespace App\Interfaces\Validators;

use App\Models\User;
use App\Models\StudentClass;

interface StudentClassValidatorInterface
{
    public function store();
    public function destroy(StudentClass $studentClass, User $user);
}
