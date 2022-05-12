<?php

namespace App\Repositories;

use App\Interfaces\AssociationRepositoryInterface;
use App\Models\Association;
use App\Models\User;
use App\Support\Enums\ErrorLogEnum;
use App\Support\ResponseMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AssociationRepository implements AssociationRepositoryInterface
{
    public function storeAssociation(Request $request, User $user)
    {
        // TODO: Implement storeAssociation() method.

        try {
            $association = Association::create([
                'creator_id' => $user->id,
                'key' => Str::slug($request->association_name . ' ' . $user->id),
                'name' => $request->association_name,
            ]);

            $user->update([
                'association_id' => $association->id
            ]);

            return ResponseMessage::returnData(true, $association);
        } catch (\Exception $exception) {
            activity()
                ->withProperties(['error' => $exception->getMessage()])
                ->log(ErrorLogEnum::STORE_ASSOCIATION_ERROR->value);

            return ResponseMessage::returnData(false);
        }

    }
}
