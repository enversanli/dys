<?php

namespace App\Interfaces;

use App\Models\Association;

interface StudentRepositoryInterface
{
    public function storeStudent();
    public function getStudentById($id);
    public function getStudents(Association $association);
    public function getTotalStudents(Association $association, $status = null);
}
