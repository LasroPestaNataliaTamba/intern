<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LeavePdfController;

Route::get('/leave-pdf/{id}', [LeavePdfController::class, 'generate'])
    ->name('leave.pdf');

Route::get('/', function () {
    return redirect()->route('filament.admin.auth.login');
});
