<?php

namespace App\Repositories;

use App\Http\Requests\Panel\StoreUserRequest;
use App\Http\Requests\Panel\UpdateUserRequest;
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
    protected $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function updateUser(UpdateUserRequest $request, User $user)
    {
        try {

            $user->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'gender' => $request->gender ?? $user->gender,
                'class_id' => $request->class_id ?? $user->class_id,
                'parent_id' => $request->parent_id ?? $user->parent_id,
                'phone' => $request->phone ?? $user->phone,
                'mobile_phone' => $request->mobile_phone ?? $user->mobile_phone,
                'status' => $request->status ?? $user->status,
                'timezone' => $request->timezone ?? $user->timezone,
                'birth_date' => $request->birth_date ? Carbon::make($request->birth_date)->format('Y-m-d') : $user->birth_date,
            ]);

            return ResponseMessage::returnData(true, $user);
        } catch (\Exception $exception) {
            activity()
                ->withProperties(['error' => $exception->getMessage()])
                ->log(ErrorLogEnum::UPDATE_STUDENT_REPOSITORY_ERROR->value);

            return ResponseMessage::returnData(false);
        }
    }


    public function getUserById($id)
    {
        try {
            $user = $this->model->where('id', $id)->first();

            if (!$user) {
                return ResponseMessage::returnData(false, null, __('user.not_found'), 404);
            }

            return ResponseMessage::returnData(true, $user);

        } catch (\Exception $exception) {
            activity()
                ->withProperties(['error' => $exception->getMessage()])
                ->log(ErrorLogEnum::GET_USER_BY_ID_REPOSITORY_ERROR->value);

            return ResponseMessage::returnData(false);
        }
    }

    public function getUsers(Request $request, Association $association, User $authUser)
    {
        try {
            $paginateData = PaginateData::fromRequest($request);

            $users = User::where('association_id', $association->id)
                ->when(isset($request->role) && $request->role != null, function ($q) use ($request) {
                    return $q->where('role_id', UserRole::where('key', $request->role)->first()->id);
                })
                ->when($request->class_id, function ($q) use ($request) {
                    return $q->where('class_id', $request->class_id);
                })
                ->when($request->search, function ($q) use ($request) {
                    return $q->where('first_name', 'like', $request->search)
                        ->orWhere('last_name', 'like', $request->search);
                });

            // If Auth user is parent then gets his/her students
            if ($authUser->isParent()) {
                $users->where('parent_id', $authUser->id);
            }

            if ($authUser->isTeacher()) {
                //$users->where('parent_id', $authUser->id);
            }

//            if ($request->has('class_id')) {
//                $users->whereHas('class', function ($q) use ($request) {
//                    return $q->where('id', $request->class_id);
//                });
//            }

            $users = $users->with('parent')->paginate($paginateData->per_page, '*', 'page', $paginateData->page);

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
            return $query->where('role_id', UserRole::where('key', UserRoleKeyEnum::STUDENT->value)->first()->id);
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
            $data = [
                'key' => Str::slug($request->first_name . '-' . $request->last_name . Str::random(16)),
                'association_id' => $association->id,
                'role_id' => UserRole::where('key', $request->role)->first()->id,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'gender' => $request->gender ?? null,
                'email' => $request->email,
                'mobile_phone' => $request->mobile_phone ?? null,
                'password' => $request->password ? Hash::make($request->password) : Hash::make(now()->timestamp),
                'verification_code' => Hash::make(Str::random()),
                'status' => UserStatusEnum::MAIL_VERIFICATION,
            ];

            if ($request->role == UserRoleKeyEnum::STUDENT) {
                $data['parent_id'] = $request->parent_id;
                $data['class_id'] = $request->class_id;
                $data['birth_date'] = $request->birth_date ? Carbon::make($request->birth_date)->format('Y-m-d') : null;
            }

            if ($request->role == UserRoleKeyEnum::PARENT) {

            }

            if ($request->role == UserRoleKeyEnum::TEACHER) {

            }

            if ($request->role == UserRoleKeyEnum::ASSOCIATION_MANAGER) {

            }

            if ($request->role == UserRoleKeyEnum::SUB_ASSOCIATION_MANAGER) {

            }

            // Create row
            $user = $this->model->create($data);

            return ResponseMessage::returnData(true, $user);
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
            // Delete user
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
