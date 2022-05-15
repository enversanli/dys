<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\StudentClassStoreRequest;
use App\Http\Resources\Panel\StudentClassResource;
use App\Interfaces\StudentClassRepositoryInterface;
use App\Support\ResponseMessage;
use Illuminate\Http\Request;

class StudentClassController extends Controller
{
    /** @var StudentClassRepositoryInterface */
    protected $studentClassRepository;

    public function __construct(StudentClassRepositoryInterface $studentClassRepository)
    {
        $this->studentClassRepository = $studentClassRepository;
    }

    public function index()
    {
        $studentClasses = $this->studentClassRepository->getClasses(auth()->user()->association);
        if (!$studentClasses->status)
            return ResponseMessage::failed();

        return ResponseMessage::success(null, StudentClassResource::collection($studentClasses->data));
    }

    public function store(StudentClassStoreRequest $request)
    {

        $storedStudentClass = $this->studentClassRepository->storeClass($request, auth()->user()->association);

        if (!$storedStudentClass->status)
            return ResponseMessage::failed($storedStudentClass->message);

        return ResponseMessage::success(null, StudentClassResource::make($storedStudentClass->data));
    }

}
