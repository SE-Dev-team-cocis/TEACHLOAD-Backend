<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{

    public function createDepartment(Request $request)
    {
        $department = Department::create([
            'department_name' => $request->departmentName,
            'department_code' => $request->departmentCode,
            'college_id' => $request->collegeId
        ]);

        return response()->json([
            'message' => $department->department_name . " created successfully"
        ], 200);
    }
    public function getDepartments()
    {
        $departments = Department::all();
        return response()->json([
            'departments' => $departments
        ], 200);
    }
}
