<?php

namespace App\Interfaces;

use App\Http\Requests\Panel\StudentClassStoreRequest;
use App\Models\Association;

interface StudentClassRepositoryInterface
{
    public function storeClass(StudentClassStoreRequest $request);
}
