<?php

namespace App\Http\Controllers;

use App\Models\TeachingLoad;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\AssigneeRequest;
use App\Models\User;
use App\Http\Traits\DashboardTrait;

class AssignmentController extends Controller
{
    use DashboardTrait;
    /** Static method to return all the load when a load is assigned */
    public static function returnLoad()
    {
        $load = TeachingLoad::all();
        $teaching_load = array();

        foreach ($load as $value) {
            $magic['id'] = $value->id;
            $magic['CUs'] = \json_decode($value->CUs);
            $magic["staff_id"] = $value->staff_id;
            $magic["courses"] = $value->courses;
            $magic["semester"] = $value->semester;
            $magic["assignee_id"] = $value->assignee_id;
            array_push($teaching_load, $magic);
        }
        return ['assignments' => $teaching_load, 'status' => true];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //function to return assignees
        try{
            $load=TeachingLoad::all();
            $teaching_load=array();

            foreach($load as $value){
                $magic['id']=$value->id;
                $magic['CUs']=\json_decode($value->CUs);
                $magic["staff_id"]=$value->staff_id;
                $magic["courses"]=$value->courses;
                $magic["semester"]=$value->semester;
                $magic["assignee_id"]=$value->assignee_id;
               array_push($teaching_load,$magic);
            }
             return response(['assignments' =>$teaching_load,'status'=>true],200);
        }catch(\Exception $e){
            return response([
                'message'=> $e->getMessage()
            ],400);
        }

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(AssigneeRequest $request)
    {

        try{
            $checkStaff = TeachingLoad::where('staff_id', '=',$request->input('staff_id'), 'and')->where('semester', '=', 1)->first();
            if($checkStaff){
                $user=User::find($checkStaff->staff_id);
                return response(['status'=>false,'message' => $user->firstName. " ".$user->lastName." already has a teaching load in this Semester"],200);
            }
           //get all teaching load from a specific staff id and semester 1
           $all_teaching = TeachingLoad::where('semester', '=', 1)->get();
           //decode the courses in $all_teaching->courses to an array and compare with $request->courses then store them in a new array $already_assigned
              $already_assigned = array();
              foreach($all_teaching as $value){
                $courses = \json_decode($value->courses);
                foreach($courses as $course){
                    if(in_array($course,\json_decode($request->courses))){
                        array_push($already_assigned,$course);
                    }
                }
            };
            /*Reset dashbooard */
                $taechingload = TeachingLoad::where(['broadcast'=> 1])->get();
                $staff = User::all();
                $sample = $this->calculate_cus($taechingload,$staff);
                $total_load = $this->categorize_load($sample);
                $deps = $this->categorize_load_dept($sample);
                $course_summary = $this->allocate_unallocate_func();
                $unallocated_courses = $this->unallocate_func();
            /* End of reset */
            /* Dasboard Reset data */
            $dasboard_response = [
                "overall_total_load" => $total_load,
                "total_staff"=>$staff->count(),
                "staff" => $sample,
                "department_load"=>$deps,
                "course_summary" => $course_summary,
                "unallocated_courses" => $unallocated_courses
                ];
            $message = implode(',', $already_assigned);
            /* if $already_assigned length is greater than zero */
            if(count($already_assigned) > 0){
                return response([
                    'status'=>false,
                    'assigned_courses' => $already_assigned,
                    'others' => $dasboard_response,
                    'message' => "$message already assigned!"
               ],200);
            }

            $assign =TeachingLoad::create([
                'courses'=> $request->input('courses'),
                'CUs'=>$request->input('CUs'),
                'staff_id'=>$request->input('staff_id'),
                'assignee_id'=>$request->input('assignee_id')
             ]);

            $assignments = $this->returnLoad();

             return response([
                'status'=>true,
                'teachingLoad' => $assign,
                'message'=>'Teaching Load has been assigned successfully',
                'assignments' => $assignments

            ],200);

        }catch(\Exception $e){
            return response([
                'message'=> $e->getMessage()
            ],400);
        }

    }

    /*Delete by teaching load id */
    public function deleteLoadById(Request $request){
        try{

            $load = TeachingLoad::where('id','=',$request->input('id'), 'and')->where('assignee_id','=',$request->input('assignee_id'),'and')->where('semester', '=',1)->delete();

            if($load == 0){
                return response(['status'=>false,'message'=>'You have no teaching load to delete'],200);
             }

             /*Get all Load */
             $assignments = $this->returnLoad();

             /*Reset dashbooard */
                $taechingload = TeachingLoad::where(['broadcast'=> 1])->get();
                $staff = User::all();
                $sample = $this->calculate_cus($taechingload,$staff);
                $total_load = $this->categorize_load($sample);
                $deps = $this->categorize_load_dept($sample);
                $course_summary = $this->allocate_unallocate_func();
                $unallocated_courses = $this->unallocate_func();
            /* End of reset */
              /* Dasboard Reset data */
              $dasboard_response = [
                "overall_total_load" => $total_load,
                "total_staff"=>$staff->count(),
                "staff" => $sample,
                "department_load"=>$deps,
                "course_summary" => $course_summary,
                "unallocated_courses" => $unallocated_courses
                ];
            /* End of Response data */


             return response([
                   'status'=>true,
                   'message'=> 'Cleared all Your load for a specific Semester',
                   'assignments' => $assignments,
                   'others' => $dasboard_response
                ],200);
        }catch(\Exception $e){
            return response([
                'message'=> $e->getMessage()
            ],400);
        }
    }


    /*delete all teaching load of a specific head of department */
    public function deleteLoad(Request $request){
        try{

            /*Test input */
            $load = TeachingLoad::where('assignee_id', '=',$request->input('assignee_id'), 'and')->where('semester', '=',1)->delete();
             if($load==0){
                return response(['status'=>false,'message'=>'You have no teaching load to delete'],200);
             }

             $assignments = $this->returnLoad();
             /*Reset dashbooard */
                $taechingload = TeachingLoad::where(['broadcast'=> 1])->get();
                $staff = User::all();
                $sample = $this->calculate_cus($taechingload,$staff);
                $total_load = $this->categorize_load($sample);
                $deps = $this->categorize_load_dept($sample);
                $course_summary = $this->allocate_unallocate_func();
                $unallocated_courses = $this->unallocate_func();
             /* End of reset */
             /* Dasboard Reset data */
            $dasboard_response = [
                    "overall_total_load" => $total_load,
                    "total_staff"=>$staff->count(),
                    "staff" => $sample,
                    "department_load"=>$deps,
                    "course_summary" => $course_summary,
                    "unallocated_courses" => $unallocated_courses
            ];
           /* End of Response data */

             return response([
                    'status'=>true,
                    'message'=>'Cleared all Your load for a specific Semester',
                    'assignments' => $assignments,
                    'others' => $dasboard_response
                ],200);
        }catch(\Exception $e){
            return response([
                'message'=> $e->getMessage()
            ],400);
        }
    }
    /* uPDATE LOAD */
    public function update_load(Request $request)
    {
        try{

           $staff_id = $request->input("staff_id");
           $teaching_load = TeachingLoad::where('staff_id', "=", $staff_id);

           if( $teaching_load->get()->count() == 0)
           {
            return response(['status'=>false,'message'=>'You have no teaching load to update',"load" => $request->staff_id],200);
           }
           /* update */
           $teaching_load->update([
             "courses" => $request->courses,
             "CUs" =>  $request->CUs
           ]);

           $load=TeachingLoad::all();
           $teaching_load=array();

           foreach($load as $value){
               $magic['id']=$value->id;
               $magic['CUs']=\json_decode($value->CUs);
               $magic["staff_id"]=$value->staff_id;
               $magic["courses"]=$value->courses;
               $magic["semester"]=$value->semester;
               $magic["assignee_id"]=$value->assignee_id;

              array_push($teaching_load,$magic);
           }

            /*Reset dashbooard */
                $taechingload = TeachingLoad::where(['broadcast'=> 1])->get();
                $staff = User::all();
                $sample = $this->calculate_cus($taechingload,$staff);
                $total_load = $this->categorize_load($sample);
                $deps = $this->categorize_load_dept($sample);
                $course_summary = $this->allocate_unallocate_func();
                $unallocated_courses = $this->unallocate_func();
           /* End of reset */
           /* Dsboard Reset data */
           $dasboard_response = [
                "overall_total_load" => $total_load,
                "total_staff"=>$staff->count(),
                "staff" => $sample,
                "department_load"=>$deps,
                "course_summary" => $course_summary,
                "unallocated_courses" => $unallocated_courses
           ];
          /* End of Response data */
           return response(['status'=>true,'message'=>"load updated successfully", "load" => $teaching_load, "others" => $dasboard_response],200);

        }catch(\Exception $e){
            return response([
                'error'=> $e->getMessage()
            ],400);
        }
    }
}
