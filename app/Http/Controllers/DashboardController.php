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

          $taechingload = TeachingLoad::all();
          $staff = User::all();
          $sample = $this->calculate_cus($taechingload,$staff);
          $total_load = $this->categorize_load($sample);
          return response(["total_load"=>$total_load, "staff" => $sample], 200);
        }
        catch (\Exception $e) {
            return response([
              'message' => $e->getMessage()
            ], 400);
          }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
