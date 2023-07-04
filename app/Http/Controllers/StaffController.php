<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;

class StaffController extends Controller
{
    /*get All Staff members */

    public function getAllStaff():Response
    {
        $staff=User::all();

        return response(['staff' => $staff], Response::HTTP_OK); //200

    }
}
