<?php

namespace App\Http\Controllers;

use App\Models\TeachingLoad;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\AssigneeRequest;

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
             return response(['assignments' => $assignment],200);
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
            $assign =TeachingLoad::create([
                'courses'=>$request->input('courses'),
                'CUs'=>$request->input('CUs'),
                'staff_id'=>$request->input('staff_id'),
                'assignee_id'=>$request->input('assignee_id')
             ]);
             return response(['assignment' => $assign],200);
        }catch(\Exception $e){
            return response([
                'message'=> $e->getMessage()
            ],400);
        }

    }

    public function deleteLoadById($id){

    }
}
