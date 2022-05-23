<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Resources\Panel\UserResource;
use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use App\Support\ResponseMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /** @var User */
    protected $user;

    private UserRepositoryInterface $userRepository;

    public function __construct(
        UserRepositoryInterface $userRepository
    )
    {
        $this->userRepository = $userRepository;

        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }

    public function index(Request $request){
        $users = $this->userRepository->getUsers($request, $this->user->association);

        if (!$users->status)
            return ResponseMessage::failed();

        return ResponseMessage::paginate(null, UserResource::collection($users->data));
    }

    public function store(){

    }

}
