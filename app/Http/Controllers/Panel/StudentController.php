<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Resources\Panel\UserResource;
use App\Interfaces\StudentRepositoryInterface;
use App\Support\ResponseMessage;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    protected StudentRepositoryInterface $studentRepository;

    public function __construct(StudentRepositoryInterface $studentRepository){
        $this->studentRepository = $studentRepository;
    }

    public function index(){
        $students = $this->studentRepository->getStudents(auth()->user()->association);

        if (!$students->status)
            return ResponseMessage::failed();

        return ResponseMessage::success(null, UserResource::collection($students->data));
    }

    public function show(){
        $student = $this->studentRepository->getStudent();

        if (!$student->status)
            return ResponseMessage::failed();

        return ResponseMessage::success(null, UserResource::make($student->data));
    }

}
