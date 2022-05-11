<?php

namespace App\Repositories;

use App\Interfaces\AssociationRepositoryInterface;
use App\Models\Association;
use App\Models\User;
use Illuminate\Http\Request;

class AssociationRepository implements AssociationRepositoryInterface
{
    public function storeAssociation(Request $request, User $user)
    {
        // TODO: Implement storeAssociation() method.

        try {


        }catch (\Exception $exception){
            return $exception->getMessage();
        }

        $association = Association::create([
            'creator_id' => $user->id,
            'name' => $request->association_name
        ]);

    }
}
