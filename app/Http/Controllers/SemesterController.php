<?php

namespace App\Http\Controllers;

use App\Models\Semester;
use Illuminate\Http\Request;

class SemesterController extends Controller
{
    public function createSemester(Request $request)
    {
        $semester = Semester::create([
            'semester_name' => $request->semesterName,
            'semester_code' => $request->semesterCode
        ]);
        
        
        return response()->json([
            'message' => $semester->semester_name . " created successfully"
        ], 200);
    }
    public function getSemesters()
    {
        $semesters = Semester::all();
        return response()->json([
            'semesters' => $semesters
        ], 200);
    }
}
