<?php

use App\Http\Controllers\API\LeadController;
use App\Http\Controllers\API\LoginController;
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

// routes/api.php

Route::post('/login', [LoginController::class, 'login']);
Route::middleware('auth:sanctum')->get('/getLeads', [LeadController::class, 'getLeads']);
Route::middleware('auth:sanctum')->post('/add', [LeadController::class, 'postLead']);
Route::middleware('auth:sanctum')->get('/getCommunication/{id}', [LeadController::class, 'getCommunication']);
Route::get('/logo', [LeadController::class, 'get_logo']);