<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserImportController;


Route::get('', [UserImportController::class, 'index'])->name('index');

Route::post('/import-users', [UserImportController::class, 'import'])->name('import-users');
