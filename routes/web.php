<?php

use App\Http\Controllers\MessageController;
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
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::group(['middleware' => ['role:admin|accountant']], function () {
    Route::get('/messages/send', \App\Http\Livewire\Message::class);
});

Route::middleware(['auth:sanctum', 'verified'])->get('/messages', [MessageController::class, 'allMessages']);

Route::middleware(['auth:sanctum', 'verified'])->get('/messages/{id}', [MessageController::class, 'getMessageById']);

Route::middleware(['auth:sanctum', 'verified'])->get('/files/{messageId}', [MessageController::class, 'getMessageFiles']);

Route::get('/test', [MessageController::class, 'test']);
