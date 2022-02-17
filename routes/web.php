<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\FriendController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\GameManageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RestrictController;
use App\Http\Controllers\TransactionHeaderController;
use Illuminate\Support\Facades\Auth;
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
    return redirect()->route('games.index');
});

Route::middleware('can:admin')->group(function(){
    Route::get('manage/game', [GameManageController::class, 'index'])->name('manage.game');
});

Route::middleware(['auth'])->group(function(){
    Route::resource('profile', ProfileController::class)->only(['index', 'update', 'show']);
});

Route::get('check-age/{game}', [RestrictController::class, 'index'])->name('restrict.index');
Route::post('check-age/{game}', [RestrictController::class, 'show'])->name('restrict.show');

Route::get('games/search', [GameController::class, 'search'])->name('games.search');
Route::resource('games', GameController::class);

Route::middleware(['auth', 'can:member'])->group(function(){
    Route::resource('cart', CartController::class)->only(['index', 'store', 'show', 'destroy']);
    Route::resource('transaction', TransactionHeaderController::class)->except(['update', 'edit', 'destroy']);
    Route::resource('friend', FriendController::class)->except(['create', 'edit']);
});


Auth::routes();


