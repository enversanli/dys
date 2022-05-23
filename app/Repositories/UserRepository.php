<?php

namespace App\Repositories;

use App\Models\Association;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Support\Str;
use App\Support\PaginateData;
use Illuminate\Http\Request;
use App\Support\ResponseMessage;
use App\Support\Enums\ErrorLogEnum;
use Illuminate\Support\Facades\Hash;
use App\Interfaces\UserRepositoryInterface;
use App\Http\Requests\Panel\RegisterRequest;

class UserRepository implements UserRepositoryInterface
{
    public function getUsers(Request $request, Association $association)
    {
        try {
            $paginateData = PaginateData::fromRequest($request);

            $users = User::where('association_id', $association->id)
                ->when($request->role != null, function ($q) use ($request){
                    $q->where('role_id', UserRole::where('key', $request->role)->first()->id);
                })
                ->paginate($paginateData->per_page, '*', 'page', $paginateData->page);

            return ResponseMessage::returnData(true, $users);
        }catch (\Exception $exception){
            dd($exception->getMessage());
            activity()
                ->withProperties(['error' => $exception->getMessage()])
                ->log(ErrorLogEnum::GET_USER_USERS_REPOSITORY->value);

            return ResponseMessage::returnData(false);
        }
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
