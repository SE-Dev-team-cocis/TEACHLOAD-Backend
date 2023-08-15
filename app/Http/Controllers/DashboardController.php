<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TeachingLoad;
use App\Models\Course;
use App\Models\User;
use App\Http\Traits\DashboardTrait;

class DashboardController extends Controller
{
    use DashboardTrait;
    public function index()
    {
        try {

          $taechingload = TeachingLoad::where(['broadcast'=> 1])->get();

        //   if($taechingload->count() < 1){
        //     return response(["message"=>"There is currently no brodcast Load", "count" => 0], 200);
        //   }

          $staff = User::all();
          $sample = $this->calculate_cus($taechingload,$staff);
          $total_load = $this->categorize_load($sample);
          $deps = $this->categorize_load_dept($sample);
          return response(['sample' => $this->allocate_unallocate_func()]);
        //   return response(["overall_total_load"=>$total_load, "total_staff"=>$staff->count(), "staff" => $sample, "department_load"=>$deps], 200);
        }
        catch (\Exception $e) {
            return response([
              'message' => $e->getMessage()
            ], 400);
          }
    }

    /* Broad Cast functionality*/

    public static function broadcast_load($id)
    {
        try{
            $user = User::find($id);
            /*check user existance */
            if($user == null)
            {
              return response(["message"=>"User does not exist", "success"=>false]);
            }

            $selected_load = TeachingLoad::where('assignee_id', $id);
            /* no load */
            if($selected_load->get()->count() < 1 ){
                return response(["message"=>"You have no load to broadcast", "success"=>false]);
            }
            $selected_load ->update(['broadcast' => true]);
            /* Return message */
            return response(["message"=>"You have successfully broadcast your assigned", "success"=>true]);
        }
        catch (\Exception $e) {
            return response([
              'message' => $e->getMessage(),
              'success' => false
            ], 400);
          }
    }
}
