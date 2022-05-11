<?php

namespace App\Interfaces;

use App\Models\User;
use Illuminate\Http\Request;

interface AssociationRepositoryInterface
{
    public function storeAssociation(Request $request, User $user);
}
