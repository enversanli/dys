<?php

namespace App\Http\Controllers\Panel;

use App\Interfaces\Validators\StudentValidatorInterface;
use App\Models\User;
use Illuminate\Http\Request;
use App\Support\ResponseMessage;
use App\Http\Controllers\Controller;
use App\Http\Resources\Panel\UserResource;
use App\Interfaces\StudentRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    protected StudentRepositoryInterface $studentRepository;

    /** @var User */
    protected $user;

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

    public function show()
    {
        $student = $this->studentRepository->getStudentById(11);

        if (!$student->status)
            return ResponseMessage::failed();

        return ResponseMessage::success(null, UserResource::make($student->data));
    }

    public function update(){

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
