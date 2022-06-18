<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Resources\Panel\UserRoleResource;
use App\Interfaces\UserRoleRepositoryInterface;
use App\Models\User;
use App\Support\ResponseMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserRoleController extends Controller
{
    /** @var User */
    protected $user;

    /** @var UserRoleRepositoryInterface */
    protected $userRoleRepository;

    public function __construct(UserRoleRepositoryInterface $userRoleRepository){
        $this->userRoleRepository = $userRoleRepository;

        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }

    public function index(){
        $userRoles = $this->userRoleRepository->getUserRoles();

        if (!$userRoles->status){
            return ResponseMessage::failed($userRoles->message, null, $userRoles->code);
        }

        return ResponseMessage::success(__('common.success'), UserRoleResource::collection($userRoles->data));
    }
}
