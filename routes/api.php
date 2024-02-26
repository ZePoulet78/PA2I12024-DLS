<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\MakeActivityController;
use App\Http\Controllers\MakeFormationController;


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

Route::get('/formations', [FormationController::class, 'index']);
Route::post('/formations', [FormationController::class, 'store']);
Route::get('/formations/{id}', [FormationController::class, 'show']);
Route::patch('/formations/{id}', [FormationController::class, 'update']);
Route::delete('/formations/{id}', [FormationController::class, 'destroy']);

//     return $request->user();
// });
Route::post('/user', [UserController::class, 'addUser']);
Route::get('/user', [UserController::class, 'index']);
Route::get('/user/{user}', [UserController::class, 'show']);
Route::delete('/user/{user}', [UserController::class, 'destroy']);
Route::patch('/user/{user}', [UserController::class, 'update']);

//register
Route::post('/demand', [RegisterController::class, 'resgisterUser']);
Route::post('/demand/a/{id}', [RegisterController::class, 'approveUser']);
Route::get('/demand', [RegisterController::class, 'indexRegister']);
Route::get('/demand/{user}', [RegisterController::class, 'showRegister']);
Route::delete('/demand/{user}', [RegisterController::class, 'rejectUser']);

//login
Route::post('/login', [LoginController::class, 'login']);

//stock
Route::post('/stock', [StockController::class, 'addProduct']);
Route::get('/stock', [StockController::class, 'indexP']);
Route::get('/stock/{id}', [StockController::class, 'showP']);
Route::delete('/stock/{id}', [StockController::class, 'destroyP']);
Route::patch('/stock/{id}', [StockController::class, 'updateP']);

//activity
Route::post('/act', [ActivityController::class, 'addActivity']);
Route::get('/act', [ActivityController::class, 'indexA']);
Route::get('/act/{id}', [ActivityController::class, 'showA']);
Route::delete('/act/{id}', [ActivityController::class, 'destroyA']);
Route::patch('/act/{id}', [ActivityController::class, 'updateA']);

//Faire Activité
Route::post('/makeActivity', [MakeActivityController::class, 'makeActivity']);
Route::get('/makeActivity', [MakeActivityController::class, 'indexMa']);

//Faire Formation
Route::post('/makeFormation', [MakeFormationController::class, 'makeFormation']);
Route::get('/makeFormation', [MakeFormationController::class, 'indexMf']);


