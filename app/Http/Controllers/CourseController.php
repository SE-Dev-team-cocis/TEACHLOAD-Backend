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
        $name='';
        $requestValue=\json_decode($request->input('subgroups'));

        foreach($requestValue as $value){
          $name=$value->subgroup_name;
          /**Iterate through array load to create multiple  */
          Subgroup::create([
               'course_id'=>$value->course_id,
               'subgroup_name'=>$value->subgroup_name,
               'no_of_students'=>$value->no_of_students
            ]);
        }
        return response(['status'=>true,'message'=>'Subgroups have been created successfully'],200);

      }catch(\Exception $e){
        return response([
            'message'=> $e->getMessage()
        ],400);
    }
   }
   /**Retrieve subgroups */
}
