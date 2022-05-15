<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\StudentClassStoreRequest;
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

    }

    public function store(StudentClassStoreRequest $request)
    {

        $storedClass = $this->studentClassRepository->storeClass($request);

        if (!$storedClass->status)
            return ResponseMessage::failed($storedClass->message);

        return ResponseMessage::success();
    }

}
