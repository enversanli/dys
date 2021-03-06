<?php

namespace App\Http\Controllers\Panel;

use App\Models\User;
use Illuminate\Http\Request;
use App\Jobs\SendQueueEmailJob;
use App\Support\ResponseMessage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Support\DTOs\Emails\EmailDataDTO;
use App\Http\Resources\Panel\UserResource;
use App\Interfaces\StudentRepositoryInterface;
use App\Http\Requests\Panel\StoreStudentRequest;
use App\Http\Requests\Panel\UpdateStudentRequest;
use App\Interfaces\Validators\StudentValidatorInterface;

class StudentController extends Controller
{
    /** @var User */
    protected $user;

    protected StudentRepositoryInterface $studentRepository;

    /** @var StudentValidatorInterface */
    protected $studentValidator;

    public function __construct(
        StudentRepositoryInterface $studentRepository,
        StudentValidatorInterface  $studentValidator
    )
    {
        $this->studentRepository = $studentRepository;
        $this->studentValidator = $studentValidator;

        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        $students = $this->studentRepository->getStudents($request, $this->user->association);

        if (!$students->status)
            return ResponseMessage::failed();

        return ResponseMessage::paginate(null, UserResource::collection($students->data));
    }

    public function show($id)
    {
        $student = $this->studentRepository->getStudentById($id);

        if (!$student->status)
            return ResponseMessage::failed();

        return ResponseMessage::success(null, UserResource::make($student->data));
    }

    public function store(StoreStudentRequest $request){

        $validator = $this->studentValidator->store($request, $this->user);

        if (!$validator->status){
            return ResponseMessage::failed($validator->message);
        }

        $storedStudent = $this->studentRepository->storeStudent($request, $this->user->association);

        if (!$storedStudent->status)
            return ResponseMessage::failed($storedStudent->message);

        /** Send Mail */
        $mailData = new EmailDataDTO();
        $mailData->view = 'mails.user.created';
        $mailData->subject = 'New Account';
        $mailData->email = $storedStudent->data->email;
        $mailData->data = (object)[
            'user' => $storedStudent->data,
            'role' => $storedStudent->data->role
        ];

        SendQueueEmailJob::dispatch($mailData);

        return ResponseMessage::success(__('user.created'), UserResource::make($storedStudent->data));
    }

    public function update(UpdateStudentRequest $request, $id)
    {
        $student = $this->studentRepository->getStudentById($id);

        $studentValidator = $this->studentValidator->update($request, $student->data);

        if (!$studentValidator->status)
            return ResponseMessage::failed($studentValidator->message);

        $updatedStudent = $this->studentRepository->updateStudent($request, $student->data);

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

        $destroyedStudent = $this->studentRepository->destroyStudent($student);

        if (!$destroyedStudent->status) {
            return ResponseMessage::failed($destroyedStudent->message);
        }

        return ResponseMessage::success(__('common.success'));
    }

}
