<?php

use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/transaction', function () {
    return view('transaction.index');
})->name('transaction.index');

Route::get('/transaction/form', function () {
    if (session('transaction')) {
        return view('transaction.confirm');
    }
    return view('transaction.form');
})->name('transaction.form');

Route::post('/transaction', [TransactionController::class, 'create'])->name('transaction.create');

Route::get('/transaction/confirm', function () {
    return view('transaction.confirm');
})->name('transaction.confirm');

Route::get('/transaction/store', [TransactionController::class, 'store'])->name('transaction.store');

Route::get('/transaction/delete_headback', [TransactionController::class, 'delete_headback'])->name('transaction.delete_headback');


