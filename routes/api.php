<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login',[\App\Http\Controllers\AuthController::class,'login']);
Route::post('/register',[\App\Http\Controllers\AuthController::class,'register']);

Route::prefix('mitra')->middleware(['auth:sanctum'])->group(function (){
    Route::match(['POST','GET'],'profile', [\App\Http\Controllers\Mitra\ProfileController::class,'index']);
    Route::post('profile/avatar', [\App\Http\Controllers\Mitra\ProfileController::class,'avatar']);

    Route::prefix('kos')->group(function (){
        Route::match(['POST','GET'],'',[\App\Http\Controllers\Mitra\KosController::class,'index']);
        Route::get('trash', [\App\Http\Controllers\Mitra\KosController::class, 'trash']);
        Route::get('restore/{id}', [\App\Http\Controllers\Mitra\KosController::class, 'restore']);
    });

});

Route::prefix('user')->middleware(['auth:sanctum'])->group(function (){
    Route::match(['POST','GET'],'profile', [\App\Http\Controllers\User\ProfileController::class,'index']);
    Route::post('profile/avatar', [\App\Http\Controllers\User\ProfileController::class,'avatar']);
    Route::prefix('kos')->group(function (){
        Route::get('',[\App\Http\Controllers\User\KosController::class,'index']);
        Route::get('{id}',[\App\Http\Controllers\User\KosController::class,'detail']);
        Route::post('rating/{id}', [\App\Http\Controllers\User\KosController::class, 'rating']);
    });

});
