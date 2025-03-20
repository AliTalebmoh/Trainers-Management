<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormateurController;

Route::get('/', [FormateurController::class, 'index'])->name('formateur.index');
Route::get('/formateur/details', [FormateurController::class, 'getFormateurDetails'])->name('formateur.details');
Route::get('/formateur/download', [FormateurController::class, 'downloadFormular'])->name('formateur.download');
Route::get('/formateur/create', [FormateurController::class, 'create'])->name('formateur.create');
Route::post('/formateur', [FormateurController::class, 'store'])->name('formateur.store');
Route::get('/formateur/{formateur_id}/edit', [FormateurController::class, 'edit'])->name('formateur.edit');
Route::put('/formateur/{formateur_id}', [FormateurController::class, 'update'])->name('formateur.update');

// Session routes
Route::get('/session/{session_id}/edit', [FormateurController::class, 'editSession'])->name('session.edit');
Route::put('/session/{session_id}', [FormateurController::class, 'updateSession'])->name('session.update');
Route::delete('/session/{session_id}', [FormateurController::class, 'deleteSession'])->name('session.delete');
