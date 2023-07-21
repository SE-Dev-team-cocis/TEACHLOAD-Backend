<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Subgroup;
class CourseController extends Controller
{
   /*get all courses of a specific college */

   public function getAllCourse():Response
   {
     $courseUnits=Course::all()->load('subgroups');
     /*return all courses Units*/

     return response(['course_units' =>$courseUnits], Response::HTTP_OK); //200
   }
   /*Create a subgroup */
   public function createSubgroup(Request $request):Response
   {
      try{
        $sub=Subgroup::create([
           'course_id'=>$request->input('course_id'),
           'subgroup_name'=>$request->input('subgroup_name'),
           'no_of_students'=>$request->input('no_of_students')
        ]);
        return response(['status'=>true,'subgroup' => $sub,'message'=>'Subgroup has been created successfully'],200);
      }catch(\Exception $e){
        return response([
            'message'=> $e->getMessage()
        ],400);
    }
   }
   /**Retrieve subgroups */
}
