<?php

namespace App\Interfaces;

use App\Models\Association;
use Illuminate\Http\Request;

interface StudentRepositoryInterface
{
    public function storeStudent();
    public function getStudentById($id);
    public function getStudents(Request $request, Association $association);
    public function getTotalStudents(Association $association, $status = null);
}
