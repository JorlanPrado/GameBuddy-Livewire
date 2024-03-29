<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\interestController;
use App\Http\Controllers\ReportController;
use App\Http\Livewire\Chat\Chat;
use App\Http\Livewire\Chat\Index;
use App\Http\Livewire\Users;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use EasyPanel\Http\Livewire\Admins\Single;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/banned', function () {
    return view('banned');
})->name('banned');

Route::get('users/status/{user_id}/{status_code}', [ProfileController::class, 'updateStatus']);
Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('users/status/{user_id}/{status_code}', [ProfileController::class, 'updateStatus']);
});

//edit interest
Route::put('update-interests/{userId}', [interestController::class, 'updateInterests'])->name('interest.edit');

require __DIR__.'/auth.php';



Route::middleware('auth')->group(function (){

    Route::get('/chat',Index::class)->name('chat.index');
    Route::get('/chat/{query}',Chat::class)->name('chat');
    
    Route::get('/users',Users::class)->name('users');
    

});

Route::get('/random-user', function () {
    $randomUser = User::inRandomOrder()->first(); // Retrieve a random user
    return response()->json($randomUser);
});

Route::get('/registration-count', function () {
    $registrationCount = User::count(); 

    return response()->json(['registrationCount' => $registrationCount]);
});

Route::post('/report', [ReportController::class, 'storeReport'])->name('report.submit');