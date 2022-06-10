<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\StudentClassStoreRequest;
use App\Http\Resources\Panel\StudentClassResource;
use App\Interfaces\StudentClassRepositoryInterface;
use App\Interfaces\Validators\StudentClassValidatorInterface;
use App\Interfaces\Validators\StudentValidatorInterface;
use App\Models\StudentClass;
use App\Models\User;
use App\Support\ResponseMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentClassController extends Controller
{
    /** @var User */
    protected $user;

    /** @var StudentClassRepositoryInterface */
    protected $studentClassRepository;

    /** @var StudentClassValidatorInterface */
    protected $studentClassValidator;

    public function __construct(
        StudentClassRepositoryInterface $studentClassRepository,
        StudentClassValidatorInterface $studentClassValidator

    )
    {
        $this->studentClassRepository = $studentClassRepository;
        $this->studentClassValidator = $studentClassValidator;

        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });

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

    public function destroy($id){
        $studentClass = $this->studentClassRepository->getStudentClassById($id, $this->user);

        if (!$studentClass->status)
            return ResponseMessage::failed($studentClass->message, null, $studentClass->code);

        $validator = $this->studentClassValidator->destroy($studentClass->data, $this->user);

        if (!$validator->status)
            return ResponseMessage::failed($validator->message, null, $validator->code);

        return ResponseMessage::success();
    }

}
