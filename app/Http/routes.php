<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::auth();

// Home
Route::get('/', ['uses' => 'HomeController@index', 'as' => 'home']);

// IPN
Route::any('donations/ipn', 'DonationsController@ipn');

// Donations
Route::get('donations', [
    'as'   => 'donations',
    'uses' => 'DonationsController@index',
]);

// News
Route::controller('news', 'NewsController');

// Admin Panel
Route::group(['prefix' => 'admin'], function () {
    // Protected Pages
    Route::group(['middleware' => 'auth'], function () {
        Route::controller('news', 'Admin\NewsController');
        Route::controller('donors', 'Admin\DonorsController');
        Route::controller('donations', 'Admin\DonationsController');
        Route::controller('settings', 'Admin\SettingsController');
        Route::controller('account', 'Admin\AccountController');
        Route::controller('users', 'Admin\UserController');
        Route::controller('groups', 'Admin\GroupController');

        Route::get('account', ['uses' => 'Admin\AccountController@getIndex', 'as' => 'profile']);

        Route::get('/', [
            'as'   => 'admin',
            'uses' => 'Admin\AdminController@index',
        ]);
    });
});