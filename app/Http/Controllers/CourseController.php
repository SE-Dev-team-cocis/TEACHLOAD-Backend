<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CourseController extends Controller
{
   /*get all courses of a specific college */

   public function getAllCourse():Response
   {
     $courseUnit=Course::all();
     /*return all courses Units*/
     return response(['course_units' => $courseUnit], Response::HTTP_OK); //200
   }
}
