<?php

namespace App\Http\Controllers\Panel;

use App\Interfaces\StudentRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Repositories\UserRepository;
use App\Support\Enums\UserStatusEnum;

class PanelController
{
    /** @var UserRepository  */
    protected UserRepositoryInterface $userRepository;

    protected StudentRepositoryInterface $studentRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        StudentRepositoryInterface $studentRepository
    ){
        $this->userRepository = $userRepository;
        $this->studentRepository = $studentRepository;
    }

    public function index(){

        $totalStudents = $this->studentRepository->getTotalStudents(auth()->user()->association, UserStatusEnum::ACTIVE->value);
        $totalPendingStudents = $this->studentRepository->getTotalStudents(auth()->user()->association, UserStatusEnum::PENDING->value);


        return view('panel.home')->with([
            'totalStudents' => $totalStudents,
            'totalPendingStudents' => $totalPendingStudents
            ]);
    }
}
