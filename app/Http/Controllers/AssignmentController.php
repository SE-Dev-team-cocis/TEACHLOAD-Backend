<?php

namespace App\Http\Controllers;

use App\Models\TeachingLoad;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\AssigneeRequest;
use App\Models\User;

class AssignmentController extends Controller
{

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


            $assign =TeachingLoad::create([
                'courses'=>$request->input('courses'),
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

            if($load==0){
                return response(['status'=>false,'message'=>'You have no teaching load to delete'],200);
             }
             return response(['status'=>true,'message'=>'Cleared all Your load for a specific Semester'],200);
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
             return response(['status'=>false,'message'=>'Cleared all Your load for a specific Semester'],200);
        }catch(\Exception $e){
            return response([
                'message'=> $e->getMessage()
            ],400);
        }
    }
}
