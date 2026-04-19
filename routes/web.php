<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\QCController;

Route::get('/', function () {
    return view('welcome');
});

// Route for QC Input Data
Route::get('/qc',         [QCController::class, 'index'])->name('qc.index');
Route::get('/qc/create',  [QCController::class, 'create'])->name('qc.create');
Route::post('/qc/store',  [QCController::class, 'store'])->name('qc.store');

