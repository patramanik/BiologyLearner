<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\ApiController;

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



Route::get('/posts/{id?}', [ApiController::class, 'postList']);

Route::get('/catagorys/{id?}', [ApiController::class, 'catagoryList']);
Route::get('/search/{name?}', [ApiController::class, 'search']);
Route::Post('/comment',[ApiController::class,'comment']);
Route::get('/data',[ApiController::class,'index']);
Route::get('/postdata/{category_id}',[ApiController::class,'postData']);
Route::get('/hedePosts',[ApiController::class,'hedePosts']);



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
