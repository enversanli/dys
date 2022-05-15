<?php

namespace App\Repositories;

use App\Interfaces\StudentRepositoryInterface;
use App\Models\Association;
use App\Models\User;
use App\Models\UserRole;
use App\Support\Enums\UserRoleKeyEnum;

class StudentRepository implements StudentRepositoryInterface
{
    public function storeStudent()
    {
        // TODO: Implement storeStudent() method.
    }
    public function getStudents(){
        return User::where('role', function ($query){
            return $query->where('role_id', UserRole::where('key', UserRoleKeyEnum::STUDENT)->first()->id);
        })
            ->where('association_id', auth()->user()->association->id)
            ->get();
    }

    public function getTotalStudents(Association $association, $status = null){
        return User::whereHas('role', function ($query){
            return $query->where('role_id', UserRole::where('key', UserRoleKeyEnum::STUDENT)->first()->id);
        })
            ->when($status != null, function ($query) use($status){
                return $query->where('status', $status);
            })
            ->where('association_id', $association->id)
            ->count();
    }
}
