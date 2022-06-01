<?php

namespace App\Http\Validators\Student;

use App\Interfaces\Validators\StudentValidatorInterface;
use App\Models\Association;
use App\Models\User;
use App\Support\ResponseMessage;

class StudentValidator implements StudentValidatorInterface
{
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
