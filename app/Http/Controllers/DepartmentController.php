<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{

    public function createDepartment(Request $request)
    {
        $department = Department::create([
            'department' => $request->departmentName,
            'department_code' => $request->departmentCode,
            'college_id' => $request->collegeId
        ]);

        return response()->json([
            'message' => $department->department. " created successfully"
        ], 200);
    }
    public function getDepartments()
    {
        $departments = Department::all()->load('courses');
        return response()->json([
            'departments' => $departments
        ], 200);
    }
}
