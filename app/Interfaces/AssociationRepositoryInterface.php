<?php

namespace App\Interfaces;

use App\Models\User;
use Illuminate\Http\Request;

interface AssociationRepositoryInterface
{
    public function getAssociationByKey($key);
    public function storeAssociation(Request $request);
    public function updateAssociation(Request $request, User $user);
}
