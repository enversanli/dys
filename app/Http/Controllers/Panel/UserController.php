<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\StoreUserRequest;
use App\Http\Requests\Panel\UpdateUserRequest;
use App\Http\Resources\Panel\UserResource;
use App\Interfaces\UserRepositoryInterface;
use App\Interfaces\Validators\UserValidatorInterface;
use App\Jobs\SendQueueEmailJob;
use App\Models\User;
use App\Support\DTOs\Emails\EmailDataDTO;
use App\Support\ResponseMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /** @var User */
    protected $user;

    private UserRepositoryInterface $userRepository;


    /** @var UserValidatorInterface */
    protected $userValidator;

    public function __construct(
        UserRepositoryInterface $userRepository,
        UserValidatorInterface $userValidator
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
        $students = $this->userRepository->getUsers($request, $this->user->association);

        if (!$students->status)
            return ResponseMessage::failed();

        return ResponseMessage::paginate(null, UserResource::collection($students->data));
    }

    public function show($id)
    {
        $student = $this->userRepository->getUserById($id);

        if (!$student->status)
            return ResponseMessage::failed();

        return ResponseMessage::success(null, UserResource::make($student->data));
    }

    public function store(StoreUserRequest $request){

        $validator = $this->userValidator->store($request, $this->user);

        if (!$validator->status){
            return ResponseMessage::failed($validator->message);
        }

        $storedStudent = $this->userRepository->storeUser($request, $this->user->association);

        if (!$storedStudent->status)
            return ResponseMessage::failed($storedStudent->message);

        /** Send Mail */
        $mailData = new EmailDataDTO();
        $mailData->view = 'mails.student.created';
        $mailData->subject = 'New Account';
        $mailData->email = $storedStudent->data->email;
        $mailData->data = (object)[
            'student' => $storedStudent->data,
            'role' => $storedStudent->data->role
        ];

        SendQueueEmailJob::dispatch($mailData);

        return ResponseMessage::success(__('student.created'), UserResource::make($storedStudent->data));
    }

    public function update(UpdateUserRequest $request, $id)
    {
        $student = $this->userRepository->getUserById($id);

        $userValidator = $this->userValidator->update($request, $student->data);

        if (!$userValidator->status)
            return ResponseMessage::failed($userValidator->message);

        $updatedStudent = $this->userRepository->updateUser($request, $student->data);

        if (!$updatedStudent->status)
            return ResponseMessage::failed();

        return ResponseMessage::success(null, UserResource::make($student->data));
    }

    public function destroy($id)
    {
        $student = User::findOrFail($id);

        $destroyedStudentValidator = $this->userValidator->destroy($student, $this->user->association);
        if (!$destroyedStudentValidator->status) {
            return ResponseMessage::failed($destroyedStudentValidator->message);
        }

        $destroyedStudent = $this->userRepository->destroyUser($student);

        if (!$destroyedStudent->status) {
            return ResponseMessage::failed($destroyedStudent->message);
        }

        return ResponseMessage::success(__('common.success'));
    }

}
