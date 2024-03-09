<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ChatController;
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

Route::post('/register', [ChatController::class, 'register']);
Route::post('/login', [ChatController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [ChatController::class, 'logout']);