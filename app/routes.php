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

// News
Route::resource('admin/news', 'NewsController');

// Home
Route::get('/', array('uses' => 'HomeController@index', 'as' => 'home'));