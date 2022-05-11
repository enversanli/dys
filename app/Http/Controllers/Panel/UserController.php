<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Interfaces\UserRepositoryInterface;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private UserRepositoryInterface $userRepository;

    public function __construct(
        UserRepositoryInterface $userRepository
    )
    {
        $this->userRepository = $userRepository;

    }

    public function index(){
        $this->userRepository->getStudents();
    }

    public function store(){


    }

}
