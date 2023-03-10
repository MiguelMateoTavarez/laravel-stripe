<?php

use App\Http\Controllers\StripeCustomerController;
use App\Http\Controllers\StripeWebhookController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('stripe')->group(function () {
    Route::post('/webhooks', [StripeWebhookController::class, 'handleWebhook']);
    Route::post('/registerCustomer', [StripeCustomerController::class, 'store']);
    Route::put('/updateCustomer/{user}', [StripeCustomerController::class, 'update'])->middleware('checkuserexists');
});