<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Interfaces\UserRepositoryInterface;
use App\Http\Requests\Panel\RegisterRequest;
use App\Interfaces\UserRoleRepositoryInterface;
use App\Repositories\AssociationRepository;
use App\Support\ResponseMessage;

class RegisterController extends Controller
{

    /**
     * @var UserRepositoryInterface
     */
    protected UserRepositoryInterface $userRepository;

    /**
     * @var UserRoleRepositoryInterface
     */
    protected UserRoleRepositoryInterface $userRoleRepository;

    /**
     * @var AssociationRepository
     */
    protected AssociationRepository $associationRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        UserRoleRepositoryInterface $userRoleRepository,
        AssociationRepository $associationRepository
    )
    {
        $this->userRepository = $userRepository;
        $this->userRoleRepository = $userRoleRepository;
        $this->associationRepository = $associationRepository;
    }

    protected function create(RegisterRequest $request)
    {

        $role = $this->userRoleRepository->getRoleByKey($request->role_key);

        if (!$role->status)
            return ResponseMessage::failed();

        $storedUser = $this->userRepository->storeUser($request, $role->data);

        if (!$storedUser->status)
            return ResponseMessage::failed();

        $storedAssociation = $this->associationRepository->storeAssociation($request, $storedUser->data);

        if (!$storedAssociation->status)
            return ResponseMessage::failed();

        return redirect()->back();
    }
}
