<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Subgroup;
use App\Models\SemesterList;
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
   /*Create a semester list */

   public function createSemesterList(Request $request):Response
   {
     try{
       $requestValue=\json_decode($request->input('semester_list'));
       foreach($requestValue as $value){
         SemesterList::create([
           'staff_id'=>$value->staff_id,
           'course_id'=>$value->course_id,
           'semester'=>$value->semester
         ]);
       }
       return response(['status'=>true,'message'=>'Semester list has been created successfully'],200);
     }catch(\Exception $e){
       return response([
         'message'=>$e->getMessage()
       ],400);
     }
   }

   /*GET ALL SEMESTER LISTS */

    public function getAllSemesterList():Response
    {
        try{
            $semesterList=SemesterList::all()->load('courses','staff');
            return response(['semester_list'=>$semesterList],Response::HTTP_OK);
          }catch(\Exception $e){
            return response([
              'message'=>$e->getMessage()
            ],400);
          }
    }
}


