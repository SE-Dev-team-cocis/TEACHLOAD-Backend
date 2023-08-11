<?php

namespace App\Http\Controllers;

use App\Models\College;
use Illuminate\Http\Request;

class CollegeController extends Controller
{

    public function createCollege(Request $request)
    {
        $college = College::create([
            'college_name' => $request->collegeName,
            'college_code' => $request->collegeCode
        ]);

        return response()->json([
            'message' => $college->college_name . " created successfully"
        ], 200);
    }
    public function getColleges()
    {
        $colleges = College::all();
        return response()->json([
            'colleges' => $colleges
        ], 200);
    }
}
