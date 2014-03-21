<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/


// IPN
Route::any('donations/ipn', 'DonationsController@ipn');

// Donations
Route::get('donations', array(
	'as'   => 'donations',
	'uses' => 'DonationsController@index',
));

// Home
Route::get('/', array('uses' => 'HomeController@index', 'as' => 'home'));

// News
Route::controller('news', 'NewsController');

// Admin Panel
Route::group(array('prefix' => 'admin'), function() {

	// Login
	Route::get('login', array('uses' => 'AccountController@getLogin', 'as' => 'login'));
	Route::post('login', array('uses' => 'AccountController@postLogin'));

	// Forgot Password
	Route::get('forgot', array('uses' => 'AccountController@getForgotPassword', 'as' => 'forgotPassword'));
	Route::post('forgot', array('uses' => 'AccountController@postForgotPassword'));

	// Reset Password
	Route::get('reset/{one?}', array('uses' => 'AccountController@getResetPassword', 'as' => 'resetPassword'));
	Route::post('reset', array('uses' => 'AccountController@postResetPassword'));

	// Protected Pages
	Route::group(array('before' => 'auth'), function() {
		Route::controller('news', 'AdminNewsController');
		Route::controller('donors', 'DonorsController');
		Route::controller('donations', 'AdminDonationsController');
		Route::controller('settings', 'SettingsController');
		Route::controller('account', 'AccountController');

		Route::get('/', array(
			'as'   => 'admin',
			'uses' => 'AdminController@index',
		));
	});

	Route::get('logout', array('as' => 'logout', function() {
		Auth::logout();

		return Redirect::route('home');
	}));
});