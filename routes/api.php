<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\CollegeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\SemesterController;

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

/*  Assignement Corner */
Route::post('/assign', [AssignmentController::class, 'create']);
Route::get('/allAssign', [AssignmentController::class, 'index']);
Route::delete('/delete', [AssignmentController::class, 'deleteLoad']);
Route::delete('/deleteload', [AssignmentController::class, 'deleteLoadById']);
Route::put('/assign', [AssignmentController::class, 'update_load']);
/* Subgroups */
Route::post('/subgroup/create', [CourseController::class, 'createSubgroup']);

/*Course Units */
Route::get('/courseUnits', [CourseController::class, 'getAllCourse']);
Route::post('/courseUnits/create', [CourseController::class, 'createCourse']);

/* Staff */
Route::get('/getStaff', [StaffController::class, 'getAllStaff'])->middleware('role:dean');;

/* Staff List */
Route::post('/semesterlist/create', [CourseController::class, 'createSemesterList']);
Route::get('/semesterlist', [CourseController::class, 'getAllSemesterList']);
Route::delete('/semesterlist/delete/{id}', [CourseController::class, 'deleteSemesterList']);

/* Dashboard */
Route::get('/dashboard', [DashboardController::class, 'index']);
Route::put('/broadcast/{id}',[DashboardController::class, 'broadcast_load']);

/* Semester */
Route::get('/semester', [SemesterController::class, 'getSemesters']);
Route::post('/semester/create', [SemesterController::class, 'createSemester']);

/* Departments */
Route::get('/department', [DepartmentController::class, 'getDepartments']);
Route::post('/department/create', [DepartmentController::class, 'createDepartment']);

/* Colleges */
Route::get('/college', [CollegeController::class, 'getColleges']);
Route::post('/college/create', [CollegeController::class, 'createCollege']);
