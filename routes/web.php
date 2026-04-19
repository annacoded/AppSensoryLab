<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QCController;

Route::get('/', function () {
    return view('welcome');
});

// Grouping biar rapi
Route::prefix('qc')->name('qc.')->group(function () {
    Route::get('/', [QCController::class, 'index'])->name('index');
    Route::get('/create', [QCController::class, 'create'])->name('create');
    Route::post('/store', [QCController::class, 'store'])->name('store');
    Route::get('/', [QCController::class, 'index'])->name('qc.index');

});