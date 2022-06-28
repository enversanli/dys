<?php

namespace App\Repositories;

use App\Http\Requests\Panel\StudentClassStoreRequest;
use App\Http\Requests\Panel\UpdateStudentClassRequest;
use App\Interfaces\StudentClassRepositoryInterface;
use App\Models\Association;
use App\Models\StudentClass;
use App\Models\User;
use App\Support\Enums\ErrorLogEnum;
use App\Support\PaginateData;
use App\Support\ResponseMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class StudentClassRepository implements StudentClassRepositoryInterface
{
    public $model;

    public function __construct(StudentClass $studentClass)
    {
        $this->model = $studentClass;
    }

    public function getClasses(Request $request, Association $association, $status = null)
    {
        $paginateData = PaginateData::fromRequest($request);
        try {
            $classes = $this->model->where('association_id', $association->id)
                ->when($status, function ($query) use ($status){
                    return $query->where('status', $status);
                })
                ->with('association')
                ->withCount('students')
                ->paginate($paginateData->per_page, '*', 'page', $paginateData->page);

            return ResponseMessage::returnData(true, $classes);
        }catch (\Exception $exception){
;            activity()
                ->withProperties(['error' => $exception->getMessage()])
                ->log(ErrorLogEnum::GET_STUDENT_CLASS_REPOSITORY_ERROR->value);

            return ResponseMessage::returnData(false);
        }
    }

    public function getStudentClassById($id, User $user){
        try {
            $studentClass = $this->model->where('id', $id)->withCount('students')->first();

            if (!$studentClass)
                return ResponseMessage::returnData(false, __('common.not_found', ['param' => 'Sınıf']), null, 404);

            return ResponseMessage::returnData(true, $studentClass);
        }catch (\Exception $exception){
            return ResponseMessage::returnData(false);
        }
    }

    public function getTotalClasses(Association $association)
    {
        $classes = $this->model->where('association_id', $association->id)
            ->count();

        return ResponseMessage::returnData(true, $classes);
    }

    public function storeClass(StudentClassStoreRequest $request, Association $association)
    {
        try {
            $classKey = Str::slug($request->name . '-' . now()->timestamp);

            // Check for same class name exist or not
            if ($this->model->where('name', $request->name)->exists())
                return ResponseMessage::returnData(false, '', __('class.already_exists'));

            // Store new class
            $studentClass = $this->model->create([
                'association_id' => $association->id,
                'creator_id' => auth()->user()->id,
                'key' => $classKey,
                'name' => $request->name,
                'description' => $request->description
            ]);

            return ResponseMessage::returnData(true, $studentClass);
        } catch (\Exception $exception) {
            // store log
            activity()
                ->withProperties(['error' => $exception->getMessage()])
                ->log(ErrorLogEnum::STORE_STUDENT_CLASS_REPOSITORY_ERROR->value);

            return ResponseMessage::returnData(false, '', __('common.went_wrong'));
        }
    }

    public function updateStudentClass(UpdateStudentClassRequest $request, StudentClass $studentClass)
    {
        try {
            $studentClass->update([
                'name' => $request->name,
                'description' => $request->description,
                'teacher_id' => $request->teacher_id ?? $studentClass->teacher_id
            ]);

            return ResponseMessage::returnData(true, $studentClass);
        }catch (\Exception $exception){
            activity()
                ->withProperties(['error' => $exception->getMessage()])
                ->log(ErrorLogEnum::UPDATE_STUDENT_CLASS_REPOSITORY_ERROR->value);
            return ResponseMessage::returnData(false);

        }
    }

    public function destroyStudentClass(StudentClass $studentClass)
    {
        try {

            User::where('class_id', $studentClass->id)->update([
                'class_id' => null
            ]);

            // Destroy Student Class
            $studentClass->delete();

            return ResponseMessage::returnData(true);
        }catch (\Exception $exception){
            // Logging
            activity()
                ->withProperties(['error' => $exception->getMessage()])
                ->log(ErrorLogEnum::DESTROY_STUDENT_CLASS_REPOSITORY_ERROR->value);

            return ResponseMessage::returnData(false);
        }
    }
}
