<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/home',                             [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/register',                         [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register',                        [App\Http\Controllers\Auth\RegisterController::class, 'register']);

Route::post('/logout',                          [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

//Admin Routes
Route::group(['prefix' => '/admin',             'as' => 'admin.', 'middleware' => ['auth']], function () {
    Route::get('/',                             [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('index');

    //Category routes 
    Route::group(['prefix' => 'category',       'as' => 'category.'], function () {
        Route::get('/',                         [App\Http\Controllers\Admin\CategoryController::class, 'index'])->name('index');
        Route::get('/create',                   [App\Http\Controllers\Admin\CategoryController::class, 'create'])->name('create');
        Route::post('/',                        [App\Http\Controllers\Admin\CategoryController::class, 'store'])->name('store');
        Route::get('/edit/{id}',                [App\Http\Controllers\Admin\CategoryController::class, 'edit'])->name('edit');
        Route::post('/update/{id}',             [App\Http\Controllers\Admin\CategoryController::class, 'update'])->name('update');
        Route::get('/delete/{id}',              [App\Http\Controllers\Admin\CategoryController::class, 'delete'])->name('delete');
    });

    //Tags routes
    Route::group(['prefix' => 'tags',       'as' => 'tags.'], function () {
        Route::get('/',                         [App\Http\Controllers\Admin\TagController::class, 'index'])->name('index');
        Route::get('/create',                   [App\Http\Controllers\Admin\TagController::class, 'create'])->name('create');
        Route::post('/',                        [App\Http\Controllers\Admin\TagController::class, 'store'])->name('store');
        Route::get('/edit/{id}',                [App\Http\Controllers\Admin\TagController::class, 'edit'])->name('edit');
        Route::post('/update/{id}',             [App\Http\Controllers\Admin\TagController::class, 'update'])->name('update');
        Route::get('/delete/{id}',              [App\Http\Controllers\Admin\TagController::class, 'delete'])->name('delete');
    });
    //Post routes
    Route::group(['prefix' => 'post',           'as' => 'post.'], function () {
        Route::get('/',                             [App\Http\Controllers\Admin\PostController::class, 'index'])->name('index');
        Route::get('/create',                       [App\Http\Controllers\Admin\PostController::class, 'create'])->name('create');
        Route::post('/',                            [App\Http\Controllers\Admin\PostController::class, 'store'])->name('store');
        Route::get('/edit/{id}',                    [App\Http\Controllers\Admin\PostController::class, 'edit'])->name('edit');
        Route::put('/update/{id}',                  [App\Http\Controllers\Admin\PostController::class, 'update'])->name('update');
        Route::get('/view/{id}',                    [App\Http\Controllers\Admin\PostController::class, 'view'])->name('view');
        Route::get('/delete/{id}',                  [App\Http\Controllers\Admin\PostController::class, 'delete'])->name('delete');
    });
});
