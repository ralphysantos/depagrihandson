<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });



Route::post('/login',[AuthController::class,'login']);
Route::post('/register',[UserController::class,'register']);


Route::middleware(['auth:sanctum'])->group(function(){

    Route::post('/logout',[AuthController::class,'logout']);

    Route::prefix('user')->middleware(['isAdmin'])->group(function(){
        Route::get('/view',[UserController::class,'view']);
        Route::post('/assign-role/{id}',[UserController::class,'assignRole']);
    });

    Route::prefix('post')->middleware(['isAdmin'])->group(function(){
        Route::get('/view',[PostController::class,'view']);
        Route::post('/create',[PostController::class,'create']);
        Route::put('/update/{id}',[PostController::class,'update']);
        Route::delete('/delete/{id}',[PostController::class,'delete']);
    });

    Route::prefix('comment')->group(function(){
        Route::get('/view',[PostController::class,'view']);
        Route::post('/create',[CommentController::class,'create']);
        Route::put('/update/{id}',[CommentController::class,'update']);
        Route::delete('/delete/{id}',[CommentController::class,'delete']);
    });
});