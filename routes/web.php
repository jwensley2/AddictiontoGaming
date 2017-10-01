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

Auth::routes();

// Home
Route::get('/', 'HomeController@index')->name('home');

// IPN
Route::any('donations/ipn', 'DonationsController@ipn');

// Donations
Route::get('donations', 'DonationsController@index')->name('donations');

// News
Route::get('articles/article/{article}', 'NewsController@article')->name('news.article');
Route::get('articles/archive', 'NewsController@archive')->name('news.archive');
Route::get('articles/archive/{month}/{year}', 'NewsController@month')->name('news.month');

// Admin Panel
Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    // Protected Pages
    Route::group(['middleware' => 'auth', 'namespace' => 'Admin\\'], function () {
        Route::resource('articles', 'ArticleController');
        Route::resource('donors', 'DonorController');
        Route::resource('donations', 'DonationController');

        // Users routes
        Route::resource('users', 'UserController');
        Route::post('/users/status/{user}/{status}', 'UserController@setStatus')->name('users.status');
        Route::post('/users/permissions/{user}', 'UserController@updatePermissions')->name('users.permissions');

        // Groups routes
        Route::resource('groups', 'GroupController');
        Route::post('/groups/permissions/{group}', 'GroupController@updatePermissions')->name('groups.permissions');

        // Settings routes
        Route::get('/settings', 'SettingsController@index')->name('settings.index');
        Route::post('/settings', 'SettingsController@update')->name('settings.update');

        // Account routes
        Route::get('/account', 'AccountController@edit')->name('account.edit');
        Route::patch('/account', 'AccountController@update')->name('account.update');
        Route::post('/account/changePassword', 'AccountController@changePassword')->name('account.changePassword');

        Route::get('/', 'AdminController@index')->name('home');
    });
});