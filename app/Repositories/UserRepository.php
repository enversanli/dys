<?php

namespace App\Repositories;

use App\Http\Requests\Panel\StoreUserRequest;
use App\Models\Association;
use App\Models\User;
use App\Models\UserRole;
use App\Support\Enums\UserRoleKeyEnum;
use App\Support\Enums\UserStatusEnum;
use Carbon\Carbon;
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
    /** @var User */
    protected $user;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function updateUser(Request $request, User $user)
    {
        try {

        } catch (\Exception $exception) {

            return ResponseMessage::returnData(false);
        }
    }

    public function getUserById($id)
    {
        try {

        } catch (\Exception $exception) {

            return ResponseMessage::returnData(false);
        }
    }

    public function getUsers(Request $request, Association $association)
    {
        try {
            $paginateData = PaginateData::fromRequest($request);

            $users = User::where('association_id', $association->id)
                ->when($request->role && $request->role != null, function ($q) use ($request) {
                    $q->where('role_id', UserRole::where('key', $request->role)->first()->id);
                })
                //->where('status', UserStatusEnum::ACTIVE)
                ->paginate($paginateData->per_page, '*', 'page', $paginateData->page);

            return ResponseMessage::returnData(true, $users);
        } catch (\Exception $exception) {

            activity()
                ->withProperties(['error' => $exception->getMessage()])
                ->log(ErrorLogEnum::GET_USER_USERS_REPOSITORY->value);

            return ResponseMessage::returnData(false);
        }
    }

    public function getTotalUsers(Association $association, $status = null)
    {
        return User::whereHas('role', function ($query) {
            return $query->where('role_id', UserRole::where('key', UserRoleKeyEnum::STUDENT)->first()->id);
        })
            ->when($status != null, function ($query) use ($status) {
                return $query->where('status', $status);
            })
            ->where('association_id', $association->id)
            ->count();
    }

    public function storeUser(StoreUserRequest $request, Association $association)
    {
        try {
            $data =[
                'key' => Str::slug($request->first_name . '-' . $request->last_name . Str::random(16)),
                'association_id' => $association->id,
                'role_id' => UserRole::where('key', $request->role)->first()->id,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'password' => Hash::make(now()->timestamp),
            ];

            if ($request->role == UserRoleKeyEnum::STUDENT){
                $data['parent_id'] = $request->parent_id;
                $data['class_id'] = $request->class_id;
                $data['birth_date'] = Carbon::make($request->birth_date)->format('Y-m-d');
            }

            if ($request->role == UserRoleKeyEnum::PARENT){

            }

            if ($request->role == UserRoleKeyEnum::TEACHER){

            }

            if ($request->role == UserRoleKeyEnum::ASSOCIATION_MANAGER){

            }

            if ($request->role == UserRoleKeyEnum::SUB_ASSOCIATION_MANAGER){

            }

            // Create row
            $student = $this->model->create($data);

            return ResponseMessage::returnData(true, $student);
        } catch (\Exception $exception) {
            activity()
                ->withProperties(['error' => $exception->getMessage()])
                ->log(ErrorLogEnum::STORE_STUDENT_REPOSITORY_ERROR->value);

            return ResponseMessage::returnData(false);
        }

    }

    public function destroyUser(User $user)
    {
        try {
            // Delete student
            $user->delete();

            return ResponseMessage::returnData(true);
        } catch (\Exception $exception) {
            activity()
                ->withProperties(['error' => $exception->getMessage()])
                ->log(ErrorLogEnum::DESTROY_USER__REPOSITORY_ERROR->value);

            return ResponseMessage::returnData(false);
        }
    }
}
