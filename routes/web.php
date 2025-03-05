<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormateurController;

Route::get('/', [FormateurController::class, 'index'])->name('formateur.index');
Route::get('/formateur/details', [FormateurController::class, 'getFormateurDetails'])->name('formateur.details');
Route::get('/formateur/download', [FormateurController::class, 'downloadFormular'])->name('formateur.download');
Route::get('/formateur/{formateur_id}/edit', [FormateurController::class, 'edit'])->name('formateur.edit');
Route::put('/formateur/{formateur_id}', [FormateurController::class, 'update'])->name('formateur.update');
