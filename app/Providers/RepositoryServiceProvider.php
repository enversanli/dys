<?php

namespace App\Providers;

use App\Http\Validators\Student\StudentValidator;
use App\Http\Validators\StudentClassValidator;
use App\Interfaces\AssociationRepositoryInterface;
use App\Interfaces\LoginRepositoryInterface;
use App\Interfaces\StudentClassRepositoryInterface;
use App\Interfaces\StudentRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Interfaces\UserRoleRepositoryInterface;
use App\Interfaces\Validators\StudentClassValidatorInterface;
use App\Interfaces\Validators\StudentValidatorInterface;
use App\Repositories\AssociationRepository;
use App\Repositories\LoginRepository;
use App\Repositories\StudentClassRepository;
use App\Repositories\StudentRepository;
use App\Repositories\UserRepository;
use App\Repositories\UserRoleRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(LoginRepositoryInterface::class, LoginRepository::class);
        $this->app->bind(StudentValidatorInterface::class, StudentValidator::class);
        $this->app->bind(StudentRepositoryInterface::class, StudentRepository::class);
        $this->app->bind(UserRoleRepositoryInterface::class, UserRoleRepository::class);
        $this->app->bind(StudentClassValidatorInterface::class, StudentClassValidator::class);
        $this->app->bind(AssociationRepositoryInterface::class, AssociationRepository::class);
        $this->app->bind(StudentClassRepositoryInterface::class, StudentClassRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
