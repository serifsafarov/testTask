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

Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::get('user', function (Request $request) {
        return $request->user();
    });

    Route::group(['prefix' => 'prize'], function () {
        Route::get('win', [\App\Http\Controllers\PrizeController::class, 'winPrize']);
        Route::post('change_to_bonus', [\App\Http\Controllers\PrizeController::class, 'changeToBonus']);
        Route::delete('reject_gift', [\App\Http\Controllers\PrizeController::class, 'rejectGift']);
    });
});
