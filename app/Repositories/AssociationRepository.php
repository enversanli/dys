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
    /** @var Association */
    protected $model;

    public function __construct(Association $association){
        $this->model = $association;
    }

    public function getAssociationByKey($key){
        try {
            $association = $this->model->where('key', $key)->first();

            if (!$association){
                return ResponseMessage::returnData(false, null, __('association.not_found'));
            }

            return ResponseMessage::returnData(true, $association);
        }catch (\Exception $exception){

            return ResponseMessage::returnData(false);
        }
    }
    public function storeAssociation(Request $request)
    {
        // TODO: Implement storeAssociation() method.

        try {
            $association = Association::create([
                //'creator_id' => $user->id,
                'key' => Str::slug($request->association_name) . '-' . now()->timestamp,
                'name' => $request->association_name,
            ]);

            //$user->update([
            //    'association_id' => $association->id
            //]);

            return ResponseMessage::returnData(true, $association);
        } catch (\Exception $exception) {
            activity()
                ->withProperties(['error' => $exception->getMessage()])
                ->log(ErrorLogEnum::STORE_ASSOCIATION_REPOSITORY_ERROR->value);

            return ResponseMessage::returnData(false);
        }

    }

    public function updateAssociation(Request $request, User $user)
    {
        // TODO: Implement updateAssociation() method.
    }
}
