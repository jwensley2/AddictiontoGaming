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

// Donations
Route::get('donations', array(
	'as'   => 'donations',
	'uses' => 'DonationsController@index'
	)
);
Route::any('donations/ipn', 'DonationsController@ipn');

// Admin
Route::group(array(
	'prefix' => 'admin',
	'before' => 'auth.admin'
), function() {
	Route::controller('news', 'NewsController');
	Route::controller('donors', 'DonorsController');
	Route::controller('donations', 'AdminDonationsController');
	Route::get('/', array('uses' => 'AdminController@index', 'as' => 'admin'));
});


// Home
Route::get('/', array('uses' => 'HomeController@index', 'as' => 'home'));