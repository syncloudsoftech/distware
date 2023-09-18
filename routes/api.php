<?php

use App\Http\Controllers;
use Illuminate\Support\Facades\Route;

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

Route::post('licensing/activate', [Controllers\API\LicensingController::class, 'activate']);
Route::post('licensing/heartbeat', [Controllers\API\LicensingController::class, 'heartbeat']);
Route::get('licensing/updates', [Controllers\API\LicensingController::class, 'updates']);
