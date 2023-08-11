<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


  /* Authentication */

    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

   /*  Assignement Coner */
    Route::post('/assign', [AssignmentController::class, 'create']);
    Route::get('/allAssign', [AssignmentController::class, 'index']);
    Route::delete('/delete', [AssignmentController::class, 'deleteLoad']);
    Route::delete('/deleteload', [AssignmentController::class, 'deleteLoadById']);

    /* Subgroups */
    Route::post('/subgroup/create', [CourseController::class, 'createSubgroup']);

    /*Course Units */
    Route::get('/courseUnits', [CourseController::class, 'getAllCourse']);
    Route::post('/courseUnits/create', [CourseController::class, 'createCourse']);

    /* Staff */
    Route::get('/getStaff', [StaffController::class, 'getAllStaff']);

    /* Staff List */
    Route::post('/semesterlist/create', [CourseController::class, 'createSemesterList']);
    Route::get('/semesterlist', [CourseController::class, 'getAllSemesterList']);

    /* Dashboard */
    Route:: get('/dashboard',[DashboardController::class, 'index']);


