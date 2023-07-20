<?php

namespace App\Http\Controllers;

use App\Models\TeachingLoad;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\AssigneeRequest;
use App\Models\User;

class AssignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //function to return assignees
        try{
            $assignment=TeachingLoad::all();
             return response(['assignments' => $assignment,'status'=>true],200);
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

             return response(['status'=>true,'teachingLoad' => $assign,'message'=>'Teaching Load has been assigned successfully'],200);
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
