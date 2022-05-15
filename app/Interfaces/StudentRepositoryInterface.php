<?php

namespace App\Interfaces;

use App\Models\Association;

interface StudentRepositoryInterface
{
    public function storeStudent();
    public function getStudents();
    public function getTotalStudents(Association $association, $status = null);
}
