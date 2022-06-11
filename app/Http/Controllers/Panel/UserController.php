<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Resources\Panel\UserResource;
use App\Interfaces\UserRepositoryInterface;
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

    public function index(Request $request)
    {
        $students = $this->userRepository->getStudents($request, $this->user->association);

        if (!$students->status)
            return ResponseMessage::failed();

        return ResponseMessage::paginate(null, UserResource::collection($students->data));
    }

    public function show($id)
    {
        $student = $this->userRepository->getStudentById($id);

        if (!$student->status)
            return ResponseMessage::failed();

        return ResponseMessage::success(null, UserResource::make($student->data));
    }

    public function store(StoreStudentRequest $request){

        $validator = $this->studentValidator->store($request, $this->user);

        if (!$validator->status){
            return ResponseMessage::failed($validator->message);
        }

        $storedStudent = $this->userRepository->storeStudent($request, $this->user->association);

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

    public function update(UpdateStudentRequest $request, $id)
    {
        $student = $this->userRepository->getStudentById($id);

        $studentValidator = $this->studentValidator->update($request, $student->data);

        if (!$studentValidator->status)
            return ResponseMessage::failed($studentValidator->message);

        $updatedStudent = $this->userRepository->updateStudent($request, $student->data);

        if (!$updatedStudent->status)
            return ResponseMessage::failed();

        return ResponseMessage::success(null, UserResource::make($student->data));
    }

    public function destroy($id)
    {
        $student = User::findOrFail($id);

        $destroyedStudentValidator = $this->studentValidator->destroy($student, $this->user->association);
        if (!$destroyedStudentValidator->status) {
            return ResponseMessage::failed($destroyedStudentValidator->message);
        }

        $destroyedStudent = $this->userRepository->destroyStudent($student);

        if (!$destroyedStudent->status) {
            return ResponseMessage::failed($destroyedStudent->message);
        }

        return ResponseMessage::success(__('common.success'));
    }

}
