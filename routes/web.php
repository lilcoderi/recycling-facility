<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\MaterialController;

Route::get('/', function () {
    return redirect()->route('facilities.index');
});

Route::middleware(['auth'])->group(function () {
    Route::resource('facilities', FacilityController::class);
    Route::get('facilities-export', [FacilityController::class, 'exportCsv'])->name('facilities.export');
    Route::resource('materials', MaterialController::class);
});

require __DIR__.'/auth.php';
