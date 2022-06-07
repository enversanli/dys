<?php

namespace App\Http\Validators\Student;

use App\Interfaces\Validators\StudentValidatorInterface;
use App\Models\Association;
use App\Models\StudentClass;
use App\Models\User;
use App\Support\ResponseMessage;
use Illuminate\Http\Client\Request;

class StudentValidator implements StudentValidatorInterface
{
    public function update(Request $request, User $student){
        try {
            $studentClass = $request->has('class_id') ? StudentClass::findOrFail($request->class_id) : null;
            if ($request->has('class_id') && $student->association->id != $studentClass->association_id){
                return ResponseMessage::returnData(false, null, '');
            }


            return ResponseMessage::returnData(true);
        }catch (\Exception $exception){
            return ResponseMessage::returnData(false);
        }
    }

    public function destroy(User $student, Association $association)
    {
        try {

            $situation = $association->whereHas('students', function ($query) use ($student){
                return $query->where('id', $student->id);
            })->exists();

            if (!$situation){
                return ResponseMessage::returnData(false, null, __('student.not_found'));
            }

            return ResponseMessage::returnData(true);
        }catch (\Exception $exception){

            return ResponseMessage::returnData(false);
        }
    }
}
