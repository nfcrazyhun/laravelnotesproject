<?php

use App\Http\Controllers\Api\v1\AuthController;
use App\Http\Controllers\Api\v1\NoteController;
use App\Http\Controllers\Api\v1\NoteTreeController;
use App\Http\Controllers\Api\v1\PendingUserController;
use App\Http\Controllers\Api\v1\ProfileController;
use App\Http\Controllers\Api\v1\UserController;
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

// Api login and register
Route::name('api.v1.')->group(function () {
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('register', [AuthController::class, 'register'])->name('register');
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->name('api.v1.')->group(function () {

    Route::resource('users', UserController::class)->only('index');

    Route::resource('pending-users', PendingUserController::class)->only(['index','store']);

    Route::resource('notes', NoteController::class)->except('show');

    Route::resource('notes-tree', NoteTreeController::class)->only('index');

    /* Profile */
    Route::get('profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('profile', [ProfileController::class, 'delete'])->name('profile.delete');
});
