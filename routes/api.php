<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LeaderController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('user')->group(function () {
    Route::get('leaderboard', [LeaderController::class,'index']);
    Route::get('leaderboard/order', [LeaderController::class,'order']);
    Route::get('leaderboard/{id}', [LeaderController::class,'show']);
    Route::post('leaderboard', [LeaderController::class,'create']);
    Route::post('leaderboard/increase/{id}', [LeaderController::class,'increase']);
    Route::post('leaderboard/decrease/{id}', [LeaderController::class,'decrease']);
    Route::delete('leaderboard/{id}', [LeaderController::class,'delete']);
    Route::put('leaderboard/{id}', [LeaderController::class,'update']);
});
