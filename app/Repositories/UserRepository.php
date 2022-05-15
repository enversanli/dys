<?php

namespace App\Repositories;

use App\Http\Requests\Panel\RegisterRequest;
use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use App\Models\UserRole;
use App\Support\Enums\ErrorLogEnum;
use App\Support\Enums\UserRoleKeyEnum;
use App\Support\ResponseMessage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserRepository implements UserRepositoryInterface
{

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

            return ResponseMessage::returnData(true, $user);
        }catch (\Exception $exception){
            activity()
                ->withProperties(['error' => $exception->getMessage()])
                ->log(ErrorLogEnum::STORE_USER_REPOSITORY_ERROR->value);

            return ResponseMessage::returnData(false);
        }

    }

    public function destroyStudent()
    {
        // TODO: Implement destroyStudent() method.
    }
}
