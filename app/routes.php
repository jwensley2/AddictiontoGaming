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

// Public Pages
Route::group(array(
	'before' => 'auth.admin'
), function() {
	// Donations
	Route::get('donations', array(
		'as'   => 'donations',
		'uses' => 'DonationsController@index',
	));

	// Home
	Route::get('/', array('uses' => 'HomeController@index', 'as' => 'home'));
});

// Admin Panel
Route::group(array(
	'prefix' => 'admin',
	'before' => 'auth.admin'
), function() {
	Route::controller('news', 'NewsController');
	Route::controller('donors', 'DonorsController');
	Route::controller('donations', 'AdminDonationsController');
	Route::controller('settings', 'SettingsController');

	Route::get('/', array(
		'as'   => 'admin',
		'uses' => 'AdminController@index',
	));

	Route::get('logout', array('as' => 'logout', function() {
		Auth::logout();

		return Redirect::route('home');
	}));
});