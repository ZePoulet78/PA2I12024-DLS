<?php

use App\Http\Middleware\CheckItRole;
use App\Http\Middleware\checkRole;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MaraudeController;
use App\Http\Controllers\FormationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\MakeActivityController;
use App\Http\Controllers\MakeFormationController;
use App\Http\Controllers\EntrepotController;
use App\Http\Controllers\MaraudeProductController;
use App\Http\Controllers\MakeMaraudeController;


use App\Http\Controllers\DocumentController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\HasRoleController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TicketCatgoryController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\AttachmentController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\CollectController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ServiceBenevolatController;


/*
|--------------------------------------------------------------------------
| API Routes                                                              |
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


    // Document by user
    Route::get('/admin/document/{id}', [DocumentController::class, 'list']);

    Route::get('/admin/user/{id}/role', [UserController::class, 'getUserRole']);
    Route::delete('/admin/user/{user}/role/{role}', [HasRoleController::class, 'deleteRole']);
    Route::post('/admin/user/{id}/role', [HasRoleController::class, 'assignRole']);
    Route::get('/role/{id}', [HasRoleController::class, 'showUsers']);

    // Register / Demandes
    Route::post('/admin/demand/a/{id}', [RegisterController::class, 'approveUser']);
    Route::get('/demand', [RegisterController::class, 'indexRegister']);
    Route::get('/demand/{user}', [RegisterController::class, 'showRegister']);
    Route::delete('/demand/{user}', [RegisterController::class, 'rejectUser']);




    // Formation
    Route::post('/formations', [FormationController::class, 'store']);
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

    // Entrepots
    Route::post('/entrepots', [EntrepotController::class, 'store']);
    Route::patch('/entrepots/{id}', [EntrepotController::class, 'update']);
    Route::delete('/entrepots/{id}', [EntrepotController::class, 'destroy']);

    // Vehicules
    Route::post('/vehicules', [VehicleController::class, 'store']);
    Route::patch('/vehicules/{id}', [VehicleController::class, 'update']);
    Route::delete('/vehicules/{id}', [VehicleController::class, 'destroy']);

    //ENTREPOT MARAUDE
    Route::post('/maraude/prod/{maraudeId}', [MaraudeProductController::class, 'addProductToMaraude']);
    Route::delete('/maraude/prod/{maraudeId}/{productId}', [MaraudeProductController::class, 'removeProductFromMaraude']);

    // Maraude
    Route::post('/maraudes', [MaraudeController::class, 'store']);
    Route::get('/maraudes/{id}', [MaraudeController::class, 'show']);
    Route::patch('/maraudes/{id}', [MaraudeController::class, 'update']);
    Route::delete('/maraudes/{id}', [MaraudeController::class, 'destroy']);

    // Collect
    Route::get('/collects', [CollectController::class, 'index']);
    Route::post('/collects', [CollectController::class, 'store']);
    Route::get('/collect/{id}', [CollectController::class, 'show']);
    Route::patch('/collects/{id}', [CollectController::class, 'update']);
    Route::delete('/collects/{id}', [CollectController::class, 'destroy']);

    // addRoutePlan
    Route::put('/collect/{id}/route', [CollectController::class, 'addRoutePlan']);

    //service
    // Route::post('/services', [ServiceController::class, 'store']);
   
    // Route::get('/services/{id}', [ServiceController::class, 'show']);
    // Route::put('/services/{id}', [ServiceController::class, 'update']);
    // Route::delete('/services/{id}', [ServiceController::class, 'delete']);

    Route::delete('/services/{id}', [ServiceController::class, 'delete']);
    Route::post('/services', [ServiceController::class, 'store']);
    Route::patch('/services/{id}', [ServiceController::class, 'update']);
    // addRoutePlan
    Route::put('/maraude/{id}/route', [MaraudeController::class, 'addRoutePlan']);

});


Route::middleware(['auth:sanctum', checkRole::class . ':0,1'])->group(function () {
    // Tickets
    Route::post('/tickets', [TicketController::class, 'store']);
    Route::get('/user/tickets/{id}', [TicketController::class, 'getTicketByUser']);
    Route::get('/user/mytickets', [TicketController::class, 'getTicketByAuthUser']);
    Route::delete('/user/tickets/{id}', [TicketController::class, 'destroyUserTickets']);

    // Comments
    Route::post('/tickets/{id}/comment', [CommentController::class, 'store']);
    Route::delete('tickets/{ticket_id}/comments/{id}', [CommentController::class, 'destroy']);

    // Attachments

    Route::post('/tickets/{id}/attachments', [AttachmentController::class, 'store']);
    Route::delete('/attachments/{id}', [AttachmentController::class, 'delete']);
    Route::get('/attachments/{id}', [AttachmentController::class, 'show']);


    Route::get('/admin/document/{id}', [DocumentController::class, 'list']);

    // Stock
    // Route::post('/stock', [StockController::class, 'addProduct']);
    // Route::get('/stock/{id}', [StockController::class, 'showP']);
    // Route::delete('/stock/{id}', [StockController::class, 'destroyP']);
    // Route::patch('/stock/{id}', [StockController::class, 'updateP']);

    Route::get('/maraudes', [MaraudeController::class, 'index']);
    // public function getMaraudesByUserId($user_id)
    Route::get('/maraudes/user/{id}', [MakeMaraudeController::class, 'getMaraudesByUserId']);

    // Formation
    Route::get('/formations', [FormationController::class, 'index']);
    Route::get('/formations/{id}', [FormationController::class, 'show']);

    //Faire Activité
    Route::post('/makeactivity', [MakeActivityController::class, 'makeActivity']);
    Route::get('/makeactivity', [MakeActivityController::class, 'indexMa']);
    Route::get('/makeactivity/{id}', [MakeActivityController::class, 'GetUsersIdByActivityId']);
    Route::get('/makeactivity/user/{id}', [MakeActivityController::class, 'GetActivityIdByUserId']);
    Route::delete('/undoactivity/{id}', [MakeActivityController::class, 'delete']);


    //Faire Maraude
    Route::post('/makemaraude', [MakeMaraudeController::class, 'makeMaraude']);
    Route::get('/makemaraude', [MakeMaraudeController::class, 'index']);
    Route::get('/makemaraude/{id}', [MakeMaraudeController::class, 'show']);

    Route::get('/makemaraude/{user_id}/{maraude_id}', [MakeMaraudeController::class, 'checkUserMaraude']);
    Route::delete('/makemaraude/{user_id}/{maraude_id}', [MakeMaraudeController::class, 'destroy']);

    // Faire formation
    Route::post('/makeFormation', [MakeFormationController::class, 'makeFormation']);
    Route::get('/makeFormation', [MakeFormationController::class, 'indexMf']);
    Route::get('/makeFormation/{id}', [MakeFormationController::class, 'GetUserByIdFormation']);


    Route::get('/entrepots', [EntrepotController::class, 'index']);
    Route::get('/entrepots/{id}', [EntrepotController::class, 'show']);

    //Stock
    Route::get('/stock/true', [StockController::class, 'indexP']);
    Route::get('/stock/false', [StockController::class, 'indexProdStock']);
    Route::get('/stock/warehouse/{warehouseId}', [StockController::class, 'GetProdByWarehouse']);
    Route::post('/stock/post/{id}', [StockController::class, 'addProductToWarehouse']);
    Route::get('/stock/{id}', [StockController::class, 'showP']);

    //Route::patch('/stock/{id}', [StockController::class, 'update']);
    Route::put('/stock/del/{id}', [StockController::class, 'RemoveQuantityFromStock']);
    Route::put('/stock/add/{id}', [StockController::class, 'addQuantityToStock']);
    Route::delete('/stock/{id}', [StockController::class, 'removeProductFromWarehouse']);

    // Voir Vehicules
    Route::get('/vehicules', [VehicleController::class, 'index']);
    Route::get('/vehicules/{id}', [VehicleController::class, 'show']);

    // voir produits dans les maraudes
    Route::get('/maraude/prod/{maraudeId}', [MaraudeProductController::class, 'showProduits']);

    // Voir collectes du camionneur
    Route::get('/user/{id}/collects', [CollectController::class, 'getUsersCollects']);

    Route::put('/volunteering/join/{id}', [ServiceBenevolatController::class, 'joinVolunteering']);
    Route::get('/volunteering', [ServiceBenevolatController::class, 'index']);  
    Route::put('/volunteering/leave/{id}', [ServiceBenevolatController::class, 'leaveVolunteering']);
    Route::get('/volunteering/volunteer', [ServiceBenevolatController::class, 'getVolunteerServices']);
    
    Route::post('/act', [ActivityController::class, 'addActivity']);
    Route::get('/act', [ActivityController::class, 'indexA']);
    Route::get('/act/{id}', [ActivityController::class, 'showA']);
    Route::delete('/act/{id}', [ActivityController::class, 'destroyA']);
    Route::patch('/act/{id}', [ActivityController::class, 'updateA']);



});

Route::middleware(['auth:sanctum', CheckItRole::class])->group(function () {
    Route::get('/it/tickets', [TicketController::class, 'index']);
    Route::get('/it/tickets/{id}', [TicketController::class, 'show']);

    Route::get('/it/tickets/category/{id}', [TicketController::class, 'getTicketByCategory']);
    Route::get('/it/ticket-categories', [TicketCatgoryController::class, 'index']);

    Route::get('/it/tickets/status/{status}', [TicketController::class, 'getTicketByStatus']);
    Route::patch('/it/tickets/{id}/status', [TicketController::class, 'changeStatus']);
    
    Route::get('/it/tickets/priority/{priority}', [TicketController::class, 'getTicketByPriority']);
        Route::patch('/it/tickets/{id}/priority', [TicketController::class, 'changePriority']);

    Route::get('/it/tickets/{id}/attachments', [TicketController::class, 'getTicketAttachments']);

    Route::get('/it/tickets/{id}/comments', [TicketController::class, 'getTicketComments']);
    
    Route::get('/it/tickets/{id}/assigned', [TicketController::class, 'getAssignedUser']);
    Route::get('/it/tickets/assigned/{id}', [TicketController::class, 'getTicketByAssigned']);
    Route::patch('/it/tickets/{id}/assign', [TicketController::class, 'assignTicket']);

    Route::patch('/it/tickets/{id}', [TicketController::class, 'update']);
    Route::delete('/it/tickets/{id}', [TicketController::class, 'destroy']);






});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout']);
    Route::get('/user', [UserController::class, 'getCurrentUser']);
    Route::post('/document/upload', [DocumentController::class, 'upload']);
    Route::delete('/document/user/{id}', [DocumentController::class, 'delete']);


});

Route::middleware(['auth:sanctum', checkRole::class . ':0,2'])->group(function () {
    // Activity
    Route::post('/act', [ActivityController::class, 'addActivity']);
    Route::get('/act', [ActivityController::class, 'indexA']);
    Route::get('/act/{id}', [ActivityController::class, 'showA']);
    Route::delete('/act/{id}', [ActivityController::class, 'destroyA']);
    Route::patch('/act/{id}', [ActivityController::class, 'updateA']);

    //service benevolat    
    //Route::get('/volunteering', [ServiceBenevolatController::class, 'index']);  
    // Route::get('/volunteering/{id}', [ServiceBenevolatController::class, 'show']);

    Route::get('/volunteering/user', [ServiceBenevolatController::class, 'getVolunteeringsByUser']);
    Route::get('/volunteering/{id}', [ServiceBenevolatController::class, 'show']);
    Route::post('/volunteering', [ServiceBenevolatController::class, 'addVolunteering']);
    Route::patch('/volunteering/{id}', [ServiceBenevolatController::class, 'update']);
    Route::delete('/volunteering/{id}', [ServiceBenevolatController::class, 'destroy']);






    Route::get('/services', [ServiceController::class, 'index']);
    Route::get('/services/{id}', [ServiceController::class, 'show']);


    


});


//register
Route::post('/register', [RegisterController::class, 'resgisterUser']);


//login
Route::post('/login', [LoginController::class, 'login']);


Route::post('/donations', [DonationController::class, 'createDonation'])->name('donations.create');
Route::get('/donations/success', [DonationController::class, 'handleSuccessfulDonation'])->name('donations.success');
Route::get('/donations/cancel', [DonationController::class, 'handleCancelledDonation'])->name('donations.cancel');



Route::post('/create-payment-intent', function (Request $request) {
    \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

    $paymentIntent = \Stripe\PaymentIntent::create([
        'amount' => $request->input('amount') * 100, // Montant en centimes
        'currency' => 'eur',
        'metadata' => [
            'order_id' => $request->input('order_id'),
        ],
    ]);

    return response()->json(['client_secret' => $paymentIntent->client_secret]);
});

Route::get('/payment-status/{id}', function ($id) {
    \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

    $paymentIntent = \Stripe\PaymentIntent::retrieve($id);

    return response()->json(['status' => $paymentIntent->status]);
});





