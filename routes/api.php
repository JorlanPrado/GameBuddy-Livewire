<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\ChatController;
use App\Http\Controllers\API\ReportController;
use App\Http\Controllers\API\InterestController;
use App\Http\Controllers\API\MatchingController;
use App\Http\Livewire\Chat\Chat;
use App\Http\Livewire\Chat\Index;
use App\Http\Livewire\Users;

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


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/conversations/{userId}/message', [ChatController::class, 'sendMessage']);
    Route::get('/conversations/{conversationId}', [ChatController::class, 'getConversation']);
    Route::get('/conversations/{conversationId}/messages', [ChatController::class,'index']);
    Route::post('/conversations/{conversationId}/messages', [ChatController::class, 'store']);
    Route::delete('/conversations/{conversationId}', [ChatController::class, 'deleteConversation']);
});


Route::get('list',[UserController::class,'list']);
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [UserController::class, 'logout']);
Route::put('update-interests/{userId}', [interestController::class, 'updateInterests']);

Route::middleware('auth:sanctum')->group(function () {
    Route::put('/users/{userId}', [UserController::class, 'update']);
    Route::delete('/users/{userId}', [UserController::class, 'destroy']);
});

Route::post('/submit-report', [ReportController::class, 'report']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/start-matching', [MatchingController::class, 'startMatching']);
});