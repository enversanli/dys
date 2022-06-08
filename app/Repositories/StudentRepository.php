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
     * Create a new student account
     */
    public function storeStudent(StoreStudentRequest $request, Association $association)
    {
        try {
            $student = $this->model->create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'birth_date' => Carbon::make($request->birth_date)->format('Y-m-d'),
                'mobile_phone' => $request->mobile_phone ?? null,
                'phone' => $request->phone ?? null,
                'class_id' => $request->class_id ?? null,
                'association_id' => $request->association_id ?? null
            ]);

            return ResponseMessage::returnData(true, $student);
        }catch (\Exception $exception){
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
     * Get requested association's students
     */
    public function getStudents(Request $request, Association $association)
    {

        $paginateData = PaginateData::fromRequest($request);

        try {
            $students = $this->model->whereHas('role', function ($query) {
                return $query->where('role_id', UserRole::where('key', UserRoleKeyEnum::STUDENT)->first()->id);
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
     * Get student by requested id
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
     * Update student's information
     */
    public function updateStudent(Request $request, User $student){
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
        }catch (\Exception $exception){
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
     * Get total student's for requested association
     */
    public function getTotalStudents(Association $association, $status = null)
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

    /**
     * @param User $user
     * @return object
     * Destroy student
     */
    public function destroyStudent(User $user)
    {
        try {
            // Delete student
            $user->delete();

            return ResponseMessage::returnData(true);
        }catch (\Exception $exception){
            activity()
                ->withProperties(['error' => $exception->getMessage()])
            ->log(ErrorLogEnum::DESTROY_STUDENT__REPOSITORY_ERROR);

            return ResponseMessage::returnData(false);
        }
    }
}
