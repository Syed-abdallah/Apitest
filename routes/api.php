<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/showdata',[StudentController::class,'index']);



Route::get('/student', function () {
    echo 'API TEST';
});


Route::post ('/register_student',[StudentController::class,'register']);
Route::post ('/login',[StudentController::class,'login']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/showdata/{id?}',[StudentController::class,'show']);
    Route::post('/create',[StudentController::class,'create']);
    Route::post('/update/{id?}',[StudentController::class,'update']);
    Route::get('/delete/{id?}',[StudentController::class,'destroy']);
    Route::get('/search/{city?}',[StudentController::class,'search']);
    Route::post('/logout',[StudentController::class,'logout']);
});
