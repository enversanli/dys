<?php

namespace App\Http\Controllers\Panel;

use App\Models\User;
use Illuminate\Http\Request;
use App\Jobs\SendQueueEmailJob;
use App\Support\ResponseMessage;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Support\DTOs\Emails\EmailDataDTO;
use App\Http\Resources\Panel\UserResource;
use App\Interfaces\UserRepositoryInterface;
use App\Http\Requests\Panel\StoreUserRequest;
use App\Http\Requests\Panel\UpdateUserRequest;
use App\Interfaces\Validators\UserValidatorInterface;

class UserController extends Controller
{
    /** @var User */
    protected $user;

    /** @var UserRepositoryInterface */
    private $userRepository;


    /** @var UserValidatorInterface */
    protected $userValidator;

    public function __construct(
        UserRepositoryInterface $userRepository,
        UserValidatorInterface  $userValidator
    )
    {
        $this->userRepository = $userRepository;
        $this->userValidator = $userValidator;

        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }

    public function index(Request $request)
    {

        $validator = $this->userValidator->index($request, $this->user);

        if (!$validator->status)
            return ResponseMessage::failed($validator->message, $validator->data, $validator->code);

        $users = $this->userRepository->getUsers($request, $this->user->association, $this->user);

        if (!$users->status)
            return ResponseMessage::failed();

        return ResponseMessage::paginate(null, UserResource::collection($users->data));
    }

    public function show(User $user)
    {
        return ResponseMessage::success(null, UserResource::make($user));
    }

    public function store(StoreUserRequest $request)
    {

        $validator = $this->userValidator->store($request, $this->user);

        if (!$validator->status) {
            return ResponseMessage::failed($validator->message);
        }

        $storedUser = $this->userRepository->storeUser($request, $this->user->association);

        if (!$storedUser->status)
            return ResponseMessage::failed($storedUser->message);

        /** Send Mail */
        $mailData = new EmailDataDTO();
        $mailData->view = 'mails.user.created';
        $mailData->subject = __('user.account_verification');
        $mailData->email = $storedUser->data->email;
        $mailData->data = (object)[
            'user' => $storedUser->data,
            'role' => $storedUser->data->role
        ];

        SendQueueEmailJob::dispatch($mailData);

        return ResponseMessage::success(__('user.created'), UserResource::make($storedUser->data));
    }

    public function update(UpdateUserRequest $request, User $user)
    {

        $userValidator = $this->userValidator->update($request, $user);

        if (!$userValidator->status)
            return ResponseMessage::failed($userValidator->message);

        $updatedUser = $this->userRepository->updateUser($request, $user);

        if (!$updatedUser->status)
            return ResponseMessage::failed();

        return ResponseMessage::success(null, UserResource::make($updatedUser->data));
    }

    public function destroy(User $user)
    {

        $destroyValidator = $this->userValidator->destroy($this->user, $user);
        if (!$destroyValidator->status) {
            return ResponseMessage::failed($destroyValidator->message);
        }

        $destroyedStudent = $this->userRepository->destroyUser($user);

        if (!$destroyedStudent->status) {
            return ResponseMessage::failed($destroyedStudent->message);
        }

        return ResponseMessage::success(__('common.success'));
    }

    public function me(){
        return ResponseMessage::success(null, UserResource::make($this->user));
    }

}
