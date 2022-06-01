<?php

namespace App\Interfaces\Validators;

use App\Models\Association;
use App\Models\User;

interface StudentValidatorInterface
{
    public function destroy(User $user, Association $association);
}
