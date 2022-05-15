<?php

namespace App\Repositories;

use App\Http\Requests\Panel\StudentClassStoreRequest;
use App\Interfaces\StudentClassRepositoryInterface;
use App\Models\StudentClass;
use App\Support\Enums\ErrorLogEnum;
use App\Support\ResponseMessage;
use Illuminate\Support\Str;

class StudentClassRepository implements StudentClassRepositoryInterface
{
    public $model;

    public function __construct(StudentClass $studentClass)
    {
        $this->model = $studentClass;
    }

    public function storeClass(StudentClassStoreRequest $request)
    {
        try {
            $classKey = Str::slug($request->name . '-' . now()->timestamp);
            if ($this->model->where('name', $request->name)->exists())
                return ResponseMessage::returnData(false, '', __('class.already_exists'));

            $studentClass = $this->model->create([
                'key' => $classKey,
                'name' => $request->name,
            ]);

            return ResponseMessage::returnData(true, $studentClass);
        } catch (\Exception $exception) {
            activity()
                ->withProperties(['error' => $exception->getMessage()])
                ->log(ErrorLogEnum::STORE_STUDENT_CLASS_REPOSITORY_ERROR->value);

            return ResponseMessage::returnData(false, '', __('common.went_wrong'));
        }
    }
}
