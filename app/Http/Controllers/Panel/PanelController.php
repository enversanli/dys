<?php

namespace App\Http\Controllers\Panel;

use App\Interfaces\StudentClassRepositoryInterface;
use App\Interfaces\StudentRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Repositories\UserRepository;
use App\Support\Enums\UserStatusEnum;

class PanelController
{
    /** @var UserRepository  */
    protected $userRepository;

    /** @var StudentRepositoryInterface  */
    protected $studentRepository;

    /** @var StudentClassRepositoryInterface */
    protected $studentClassRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        StudentRepositoryInterface $studentRepository,
        StudentClassRepositoryInterface $studentClassRepository
    ){
        $this->userRepository = $userRepository;
        $this->studentRepository = $studentRepository;
        $this->studentClassRepository = $studentClassRepository;
    }

    public function index(){

        $totalStudents = $this->studentRepository->getTotalStudents(auth()->user()->association, UserStatusEnum::ACTIVE->value);
        $totalPendingStudents = $this->studentRepository->getTotalStudents(auth()->user()->association, UserStatusEnum::PENDING->value);
        $totalStudentClasses = $this->studentClassRepository->getTotalClasses(auth()->user()->association);

        return view('panel.home')->with([
            'totalStudents' => $totalStudents,
            'totalPendingStudents' => $totalPendingStudents,
            'totalStudentClasses' => $totalStudentClasses->data
            ]);
    }
}
