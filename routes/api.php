<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\PasswordResetController;
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
Route::post ('/send_email',[PasswordResetController::class,'reset_email_password']);
Route::get ('/update_reset_password',[PasswordResetController::class,'update_reset_password']);


Route::get('update_reset_password/{token}', [PasswordResetController::class, 'update_reset_password'])->name('update_reset_password');
Route::post('/reset/{token}', [PasswordResetController::class, 'reset'])->name('reset');













Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/showdata/{id?}',[StudentController::class,'show']);
    Route::post('/create',[StudentController::class,'create']);
    Route::post('/update/{id?}',[StudentController::class,'update']);
    Route::get('/delete/{id?}',[StudentController::class,'destroy']);
    Route::get('/search/{city?}',[StudentController::class,'search']);
    Route::post('/logout',[StudentController::class,'logout']);
    Route::get('/user_logged',[StudentController::class,'user_logged']);
    Route::post('/change_password',[StudentController::class,'change_password']);
});
