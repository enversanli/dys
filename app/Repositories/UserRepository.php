<?php

namespace App\Repositories;

use App\Http\Requests\Panel\RegisterRequest;
use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserRepository implements UserRepositoryInterface
{

    public function getStudents(){
        return User::all();
    }

    public function storeUser(RegisterRequest $request, UserRole $userRole)
    {
        try {
            $user = User::create([
                'key' => Str::uuid(),
                'role_id' => $userRole->id,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'password' => Hash::make($request->password),
                'email' => $request->email,
            ]);

            return $user;
        }catch (\Exception $exception){
            dd($exception->getMessage());
            return $exception->getMessage();
        }

    }

    public function destroyStudent()
    {
        // TODO: Implement destroyStudent() method.
    }
}
