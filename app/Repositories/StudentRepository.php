<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\UserRole;
use App\Models\Association;
use App\Support\PaginateData;
use App\Support\ResponseMessage;
use App\Support\Enums\ErrorLogEnum;
use App\Support\Enums\UserRoleKeyEnum;
use App\Interfaces\StudentRepositoryInterface;
use Illuminate\Http\Request;

class StudentRepository implements StudentRepositoryInterface
{
    protected $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function storeStudent()
    {
        // TODO: Implement storeStudent() method.
    }

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

    public function getStudentById($id)
    {
        $student = $this->model->where('id', $id)->firstOrFail();

        try {

            return ResponseMessage::returnData(true, $student);
        } catch (\Exception $exception) {
            activity()
                ->withProperties(['error' => $exception->getMessage()])
                ->log(ErrorLogEnum::GET_STUDENT_BY_ID_REPOSITORY_ERROR->value);

            return ResponseMessage::returnData(false);
        }
    }

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
