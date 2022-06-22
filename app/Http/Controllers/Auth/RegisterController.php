<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\StoreUserRequest;
use App\Interfaces\UserRepositoryInterface;
use App\Http\Requests\Panel\RegisterRequest;
use App\Interfaces\UserRoleRepositoryInterface;
use App\Repositories\AssociationRepository;
use App\Repositories\AuthRepository;
use App\Support\Enums\UserRoleKeyEnum;
use App\Support\ResponseMessage;

class RegisterController extends Controller
{

    /**
     * @var UserRepositoryInterface
     */
    protected UserRepositoryInterface $userRepository;

    /** @var AuthRepository */
    protected $authRepository;

    /**
     * @var UserRoleRepositoryInterface
     */
    protected UserRoleRepositoryInterface $userRoleRepository;

    /**
     * @var AssociationRepository
     */
    protected AssociationRepository $associationRepository;

    public function __construct(
        AuthRepository              $authRepository,
        UserRepositoryInterface     $userRepository,
        AssociationRepository       $associationRepository,
        UserRoleRepositoryInterface $userRoleRepository,
    )
    {
        $this->authRepository = $authRepository;
        $this->userRepository = $userRepository;
        $this->userRoleRepository = $userRoleRepository;
        $this->associationRepository = $associationRepository;
    }

    protected function create(StoreUserRequest $request)
    {
        $newAssociation = false;


        $role = $this->userRoleRepository->getRoleByKey($request->role);

        if (!$role->status)
            return redirect()->back()->with(['message' => $role->message]);

        if ($request->role == UserRoleKeyEnum::ASSOCIATION_MANAGER->value) {
            $association = $this->associationRepository->storeAssociation($request);
            $newAssociation = true;
        }

        if ($request->role != UserRoleKeyEnum::ASSOCIATION_MANAGER && $request->association && !isset($association)) {
            $association = $this->associationRepository->getAssociationByKey($request->association);
        }

        if (!$association->status)
            return ResponseMessage::failed();


        $storedUser = $this->userRepository->storeUser($request, $association->data);

        if (!$storedUser->status)
            return redirect()->back()->with(['message' => $storedUser->message]);

        if ($request->role == UserRoleKeyEnum::ASSOCIATION_MANAGER && $newAssociation) {
            $association->data->update([
                'creator_id' => $storedUser->data->id
            ]);
        }
        return redirect()->back()->with(['message' => 'Gayet iyi']);
    }
}
