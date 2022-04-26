<?php

use App\Http\Controllers\NoteController;
use App\Http\Controllers\NoteTreeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PendingUserController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';

Route::middleware('auth')->group(function () {
    Route::view('about', 'about')->name('about');

    Route::resource('users', UserController::class)->only('index');

    Route::resource('pending-users', PendingUserController::class)->only(['index','store']);

    Route::resource('notes', NoteController::class)->except('show');

    Route::resource('notes-tree', NoteTreeController::class)->only('index');

    /* Profile */
    Route::get('profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('profile', [ProfileController::class, 'delete'])->name('profile.delete');
});
