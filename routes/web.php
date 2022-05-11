<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\DonationController;
use App\Http\Controllers\Admin\DonorController;
use App\Http\Controllers\Admin\GroupController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\DonationsController;
use App\Http\Controllers\NewsController;

Auth::routes();

// Home
Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');

// IPN
Route::any('donations/ipn', [DonationsController::class, 'ipn']);

// Donations
Route::get('donations', [DonationsController::class, 'index'])->name('donations');

// News
Route::get('articles/article/{article}', [NewsController::class, 'article'])->name('news.article');
Route::get('articles/archive', [NewsController::class, 'archive'])->name('news.archive');
Route::get('articles/archive/{month}/{year}', [NewsController::class, 'month'])->name('news.month');

// Admin Panel
Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    // Protected Pages
    Route::group(['middleware' => 'auth'], function () {
        Route::resource('articles', ArticleController::class);
        Route::resource('donors', DonorController::class);
        Route::resource('donations', DonationController::class);

        // Users routes
        Route::resource('users', UserController::class);
        Route::post('/users/status/{user}/{status}', [UserController::class, 'setStatus'])->name('users.status');
        Route::post('/users/permissions/{user}', [UserController::class, 'updatePermissions'])->name('users.permissions');

        // Groups routes
        Route::resource('groups', GroupController::class);
        Route::post('/groups/permissions/{group}', [GroupController::class, 'updatePermissions'])->name('groups.permissions');

        // Settings routes
        Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
        Route::post('/settings', [SettingsController::class, 'update'])->name('settings.update');

        // Account routes
        Route::get('/account', [AccountController::class, 'edit'])->name('account.edit');
        Route::patch('/account', [AccountController::class, 'update'])->name('account.update');
        Route::post('/account/changePassword', [AccountController::class, 'changePassword'])->name('account.changePassword');

        Route::get('/', [AdminController::class, 'index'])->name('home');
    });
});
