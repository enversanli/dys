<?php

namespace App\Repositories;

use App\Http\Requests\Panel\StoreStudentRequest;
use App\Models\User;
use App\Models\UserRole;
use App\Models\Association;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Support\PaginateData;
use App\Support\ResponseMessage;
use App\Support\Enums\ErrorLogEnum;
use App\Support\Enums\UserRoleKeyEnum;
use App\Interfaces\StudentRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class StudentRepository implements StudentRepositoryInterface
{
    protected $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    /**
     * @param StoreStudentRequest $request
     * @param Association $association
     * @return object
     * Create a new user account
     */
    public function storeStudent(StoreStudentRequest $request, Association $association)
    {
        try {
            $student = $this->model->create([
                'key' => Str::slug($request->first_name . '-' . $request->last_name . Str::random(16)),
                'association_id' => $association->id,
                'role_id' => UserRole::where('key', UserRoleKeyEnum::STUDENT->value)->first()->id,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'password' => Hash::make(now()->timestamp),
                'birth_date' => Carbon::make($request->birth_date)->format('Y-m-d'),
                'mobile_phone' => $request->mobile_phone ?? null,
                'phone' => $request->phone ?? null,
                'class_id' => $request->class_id ?? null,
                'parent_id' => $request->parent_id ?? null,
            ]);

            return ResponseMessage::returnData(true, $student);
        } catch (\Exception $exception) {
            activity()
                ->withProperties(['error' => $exception->getMessage()])
                ->log(ErrorLogEnum::STORE_STUDENT_REPOSITORY_ERROR->value);

            return ResponseMessage::returnData(false);
        }
    }

    /**
     * @param Request $request
     * @param Association $association
     * @return object
     * Get requested association's users
     */
    public function getStudents(Request $request, Association $association)
    {
        $paginateData = PaginateData::fromRequest($request);

        try {
            $students = $this->model->whereHas('role', function ($query) {
                return $query->where('role_id', UserRole::where('key', UserRoleKeyEnum::STUDENT->value)->first()->id);
            })
                ->where('association_id', $association->id)
                ->where('association_id', auth()->user()->association->id)
                ->with(['class', 'association'])
                ->paginate($paginateData->per_page, '*', 'page', $paginateData->page);

            return ResponseMessage::returnData(true, $students);
        } catch (\Exception $exception) {
            activity()
                ->withProperties(['error' => $exception->getMessage()])
                ->log(ErrorLogEnum::GET_STUDENT_LIST_REPOSITORY_ERROR->value);

            return ResponseMessage::returnData(false);
        }
    }

    /**
     * @param $id
     * @return object
     * Get user by requested id
     */
    public function getStudentById($id)
    {
        $student = $this->model->where('id', $id)
            ->with(['parent', 'class', 'association'])
            ->firstOrFail();

        try {

            return ResponseMessage::returnData(true, $student);
        } catch (\Exception $exception) {
            activity()
                ->withProperties(['error' => $exception->getMessage()])
                ->log(ErrorLogEnum::GET_STUDENT_BY_ID_REPOSITORY_ERROR->value);

            return ResponseMessage::returnData(false);
        }
    }

    /**
     * @param Request $request
     * @param User $student
     * @return object
     * Update user's information
     */
    public function updateStudent(Request $request, User $student)
    {
        try {

            $student->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'class_id' => $request->class_id ?? $student->class_id,
                'phone' => $request->phone ?? $student->phone,
                'mobile_phone' => $request->mobile_phone ?? $student->mobile_phone,
                'status' => $request->status ?? $student->status,
                'timezone' => $request->timezone ?? $student->timezone,
                'birth_date' => $request->birth_date ? Carbon::make($request->birth_date)->format('Y-m-d') : $student->birth_date,
            ]);

            return ResponseMessage::returnData(true, $student);
        } catch (\Exception $exception) {
            activity()
                ->withProperties(['error' => $exception->getMessage()])
                ->log(ErrorLogEnum::UPDATE_STUDENT_REPOSITORY_ERROR->value);

            return ResponseMessage::returnData(false);
        }
    }

    /**
     * @param Association $association
     * @param null $status
     * @return mixed
     * Get total user's for requested association
     */
    public function getTotalStudents(Association $association, $status = null)
    {

        return User::where('role_id', UserRole::where('key', UserRoleKeyEnum::STUDENT->value)->first()->id)
            ->when($status != null, function ($query) use ($status) {
                return $query->where('status', $status);
            })
            ->where('association_id', $association->id)
            ->count();
    }

    /**
     * @param User $user
     * @return object
     * Destroy user
     */
    public function destroyStudent(User $user)
    {
        try {
            // Delete user
            $user->delete();

            return ResponseMessage::returnData(true);
        } catch (\Exception $exception) {
            activity()
                ->withProperties(['error' => $exception->getMessage()])
                ->log(ErrorLogEnum::DESTROY_STUDENT__REPOSITORY_ERROR);

            return ResponseMessage::returnData(false);
        }
    }
}
