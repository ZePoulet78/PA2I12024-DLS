<?php

use App\Http\Middleware\CheckItRole;
use App\Http\Middleware\checkRole;
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
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\HasRoleController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TicketCatgoryController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\AttachmentController;

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



Route::middleware(['auth:sanctum',checkRole::class . ':0'])->group(function () {
    // Users
    Route::post('/admin/user', [UserController::class, 'addUser']);
    Route::get('/admin/users', [UserController::class, 'index']);
    Route::get('/admin/user/{user}', [UserController::class, 'show']);
    Route::delete('/admin/user/{user}', [UserController::class, 'destroy']);
    Route::patch('/admin/user/{user}', [UserController::class, 'update']);

    Route::post('admin/user/{id}/role', [HasRoleController::class, 'assignRole']);


    // Register / Demandes
    Route::post('/admin/demand/a/{id}', [RegisterController::class, 'approveUser']);
    Route::get('/demand', [RegisterController::class, 'indexRegister']);
    Route::get('/demand/{user}', [RegisterController::class, 'showRegister']);
    Route::delete('/demand/{user}', [RegisterController::class, 'rejectUser']);

    // Stock
    Route::post('/stock', [StockController::class, 'addProduct']);
    Route::get('/stock', [StockController::class, 'indexP']);
    Route::get('/stock/{id}', [StockController::class, 'showP']);
    Route::delete('/stock/{id}', [StockController::class, 'destroyP']);
    Route::patch('/stock/{id}', [StockController::class, 'updateP']);

    // Activity
    Route::post('/act', [ActivityController::class, 'addActivity']);
    Route::get('/act', [ActivityController::class, 'indexA']);
    Route::get('/act/{id}', [ActivityController::class, 'showA']);
    Route::delete('/act/{id}', [ActivityController::class, 'destroyA']);
    Route::patch('/act/{id}', [ActivityController::class, 'updateA']);

    // Formation
    Route::get('/formations', [FormationController::class, 'index']);
    Route::post('/formations', [FormationController::class, 'store']);
    Route::get('/formations/{id}', [FormationController::class, 'show']);
    Route::patch('/formations/{id}', [FormationController::class, 'update']);
    Route::delete('/formations/{id}', [FormationController::class, 'destroy']);

    // Roles
    Route::post('/admin/roles', [RoleController::class, 'store']);    
    Route::get('/admin/roles', [RoleController::class, 'index']);
    Route::get('/admin/roles/{id}', [RoleController::class, 'show']);
    Route::patch('/admin/roles/{id}', [RoleController::class, 'update']);
    Route::delete('/admin/roles/{id}', [RoleController::class, 'delete']);

    // Ticket Categories
    Route::get('/admin/ticket-categories', [TicketCatgoryController::class, 'index']);
    Route::post('/admin/ticket-categories', [TicketCatgoryController::class, 'store']);
    Route::get('/admin/ticket-categories/{id}', [TicketCatgoryController::class, 'show']);
    Route::patch('/admin/ticket-categories/{id}', [TicketCatgoryController::class, 'update']);
    Route::delete('/admin/ticket-categories/{id}', [TicketCatgoryController::class, 'destroy']);

});


Route::middleware(['auth:sanctum', checkRole::class . ':0,1'])->group(function () {
    // Tickets
    Route::post('/tickets', [TicketController::class, 'store']);
    Route::get('/user/tickets/{id}', [TicketController::class, 'getTicketByUser']);
    Route::delete('/user/tickets/{id}', [TicketController::class, 'destroyUserTickets']);

    // Comments
    Route::post('/tickets/{id}/comment', [CommentController::class, 'store']);
    Route::delete('tickets/{ticket_id}/comments/{id}', [CommentController::class, 'destroy']);

    // Attachments

    Route::post('/tickets/{id}/attachments', [AttachmentController::class, 'store']);
    Route::delete('/attachments/{id}', [AttachmentController::class, 'delete']);
    Route::get('/attachments/{id}', [AttachmentController::class, 'show']);
});

Route::middleware(['auth:sanctum', CheckItRole::class])->group(function () {
    Route::get('/it/tickets', [TicketController::class, 'index']);
    Route::get('/it/tickets/{id}', [TicketController::class, 'show']);

    Route::get('/it/tickets/category/{id}', [TicketController::class, 'getTicketByCategory']);

    Route::get('/it/tickets/status/{status}', [TicketController::class, 'getTicketByStatus']);
    Route::get('/it/tickets/priority/{priority}', [TicketController::class, 'getTicketByPriority']);
    
    Route::get('/it/tickets/{id}/attachments', [TicketController::class, 'getTicketAttachments']);

    Route::get('/it/tickets/{id}/comments', [TicketController::class, 'getTicketComments']);
    
    // get assigned user
    Route::get('/it/tickets/{id}/assigned', [TicketController::class, 'getAssignedUser']);

    Route::patch('/it/tickets/{id}', [TicketController::class, 'update']);
    Route::delete('/it/tickets/{id}', [TicketController::class, 'destroy']);

    Route::patch('/it/tickets/{id}/priority', [TicketController::class, 'changePriority']);
    Route::patch('/it/tickets/{id}/assign', [TicketController::class, 'assignTicket']);
    Route::patch('/it/tickets/{id}/status', [TicketController::class, 'changeStatus']);

    // get ticket categories
    Route::get('/it/ticket-categories', [TicketCatgoryController::class, 'index']);

    // get ticket by assigned user
    Route::get('/it/tickets/assigned/{id}', [TicketController::class, 'getTicketByAssigned']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout']);
    Route::get('/user', [UserController::class, 'getCurrentUser']);
    Route::post('/document/upload', [DocumentController::class, 'upload']);
    Route::delete('/document/delete', [DocumentController::class, 'delete']);
});

//register
Route::post('/register', [RegisterController::class, 'resgisterUser']);
Route::get('/admin/joining', [RegisterController::class, 'indexRegister']);

//login
Route::post('/login', [LoginController::class, 'login']);

//Faire Activité
Route::post('/makeActivity', [MakeActivityController::class, 'makeActivity']);
Route::get('/makeActivity', [MakeActivityController::class, 'indexMa']);

//Faire Formation
Route::post('/makeFormation', [MakeFormationController::class, 'makeFormation']);
Route::get('/makeFormation', [MakeFormationController::class, 'indexMf']);
