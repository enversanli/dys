<?php

namespace App\Providers;

use App\Interfaces\AssociationRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Interfaces\UserRoleRepositoryInterface;
use App\Repositories\AssociationRepository;
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
        $this->app->bind(UserRoleRepositoryInterface::class, UserRoleRepository::class);
        $this->app->bind(AssociationRepositoryInterface::class, AssociationRepository::class);
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
