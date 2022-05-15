<?php

namespace App\Interfaces;

use App\Http\Requests\Panel\StudentClassStoreRequest;
use App\Models\Association;

interface StudentClassRepositoryInterface
{
    public function getClasses(Association $association, $status = null);
    public function getTotalClasses(Association $association);
    public function storeClass(StudentClassStoreRequest $request, Association $association);
}
