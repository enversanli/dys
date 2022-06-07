<?php

namespace App\Interfaces\Validators;

use App\Models\Association;
use App\Models\User;
use Illuminate\Http\Client\Request;

interface StudentValidatorInterface
{
    public function update(Request $user, User $association);
    public function destroy(User $user, Association $association);
}
