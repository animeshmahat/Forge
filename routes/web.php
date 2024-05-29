<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/home',                             [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/register',                         [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register',                        [App\Http\Controllers\Auth\RegisterController::class, 'register']);

Route::post('/logout',                          [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

//Admin Routes
Route::group(['prefix' => '/admin',             'as' => 'admin.', 'middleware' => ['auth', 'role:superadmin']], function () {
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

    // Tags routes
    Route::group(['prefix' => 'tags', 'as' => 'tags.'], function () {
        Route::get('/', [App\Http\Controllers\Admin\TagController::class, 'index'])->name('index');
        Route::post('/store', [App\Http\Controllers\Admin\TagController::class, 'store'])->name('store');
        Route::post('/update/{id}', [App\Http\Controllers\Admin\TagController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [App\Http\Controllers\Admin\TagController::class, 'delete'])->name('delete');
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
    //User Profile
    Route::group(['prefix' => 'profile',        'as' => 'profile.'], function () {
        Route::get('/edit/{id}',                [App\Http\Controllers\Admin\UserProfileController::class, 'edit'])->name('edit');
        Route::put('/update/{id}',              [App\Http\Controllers\Admin\UserProfileController::class, 'update'])->name('update');
        Route::put('passwordChange/{id}',       [App\Http\Controllers\Admin\UserProfileController::class, 'passwordChange'])->name('passwordChange');
    });
    //Settings routes
    Route::group(['prefix' => 'setting',        'as' => 'setting.'], function () {
        Route::get('/',                         [App\Http\Controllers\Admin\SettingController::class, 'index'])->name('index');
        Route::get('/edit/{id}',                [App\Http\Controllers\Admin\SettingController::class, 'edit'])->name('edit');
        Route::put('/update/{id}',              [App\Http\Controllers\Admin\SettingController::class, 'update'])->name('update');
        Route::get('/edit_site_image/{id}',     [App\Http\Controllers\Admin\SettingController::class, 'edit_site_image'])->name('edit_site_image');
        Route::put('/update_site_image/{id}',   [App\Http\Controllers\Admin\SettingController::class, 'update_site_image'])->name('update_site_image');
        Route::get('/edit_socials/{id}',        [App\Http\Controllers\Admin\SettingController::class, 'edit_socials'])->name('edit_socials');
        Route::put('/update_socials/{id}',      [App\Http\Controllers\Admin\SettingController::class, 'update_socials'])->name('update_socials');
    });
    //User routes
    Route::group(['prefix' => 'users',          'as' => 'users.'], function () {
        Route::get('/',                         [App\Http\Controllers\Admin\UserController::class, 'index'])->name('index');
        Route::get('/create',                   [App\Http\Controllers\Admin\UserController::class, 'create'])->name('create');
        Route::post('/',                        [App\Http\Controllers\Admin\UserController::class, 'store'])->name('store');
        Route::get('/view/{id}',                [App\Http\Controllers\Admin\UserController::class, 'view'])->name('view');
        Route::get('/edit/{id}',                [App\Http\Controllers\Admin\UserController::class, 'edit'])->name('edit');
        Route::put('/update/{id}',              [App\Http\Controllers\Admin\UserController::class, 'update'])->name('update');
        Route::get('/delete/{id}',              [App\Http\Controllers\Admin\UserController::class, 'delete'])->name('delete');
    });
});

//Blogger routes
Route::group(['prefix' => '/blogger',             'as' => 'blogger.', 'middleware' => ['auth']], function () {
    Route::get('/',                             [App\Http\Controllers\Blogger\DashboardController::class, 'index'])->name('index');

    //Post routes
    Route::group(['prefix' => 'post',           'as' => 'post.'], function () {
        Route::get('/',                             [App\Http\Controllers\Blogger\PostController::class, 'index'])->name('index');
        Route::get('/create',                       [App\Http\Controllers\Blogger\PostController::class, 'create'])->name('create');
        Route::post('/',                            [App\Http\Controllers\Blogger\PostController::class, 'store'])->name('store');
        Route::get('/edit/{id}',                    [App\Http\Controllers\Blogger\PostController::class, 'edit'])->name('edit');
        Route::put('/update/{id}',                  [App\Http\Controllers\Blogger\PostController::class, 'update'])->name('update');
        Route::get('/view/{id}',                    [App\Http\Controllers\Blogger\PostController::class, 'view'])->name('view');
        Route::get('/delete/{id}',                  [App\Http\Controllers\Blogger\PostController::class, 'delete'])->name('delete');
    });
    //User Profile
    Route::group(['prefix' => 'profile',        'as' => 'profile.'], function () {
        Route::get('/edit/{id}',                [App\Http\Controllers\Blogger\UserProfileController::class, 'edit'])->name('edit');
        Route::put('/update/{id}',              [App\Http\Controllers\Blogger\UserProfileController::class, 'update'])->name('update');
        Route::put('passwordChange/{id}',       [App\Http\Controllers\Blogger\UserProfileController::class, 'passwordChange'])->name('passwordChange');
    });
});

//Site routes
Route::group(['as' => 'site.',                  'namespace' => 'Site'], function () {
    Route::get('/',                             [App\Http\Controllers\Site\SiteController::class, 'index'])->name('index');
    Route::get('/post/{slug}',                  [App\Http\Controllers\Site\SiteController::class, 'single_post'])->name('single_post');
    Route::post('/post/{post_id}/comment',      [App\Http\Controllers\Admin\CommentController::class, 'store'])->name('comment.store');
    Route::get('/category/{name}',              [App\Http\Controllers\Site\SiteController::class, 'category'])->name('category');
    Route::get('/contact_us',                   [App\Http\Controllers\Site\SiteController::class, 'contact_us'])->name('contact_us');
    Route::post('/',                            [App\Http\Controllers\Admin\ContactUsController::class, 'store'])->name('contact.store');
});
