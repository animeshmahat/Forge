<?php

use Illuminate\Support\Facades\Route;

//Admin Routes
Route::group(['prefix' => '/admin',             'as' => 'admin.'], function () {
    Route::get('/',                             [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('index');
});
