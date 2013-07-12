<?php

return array(

	/*
	|--------------------------------------------------------------------------
	| Database Connections
	|--------------------------------------------------------------------------
	|
	| Here are each of the database connections setup for your application.
	| Of course, examples of configuring each database platform that is
	| supported by Laravel is shown below to make development simple.
	|
	|
	| All database work in Laravel is done through the PHP PDO facilities
	| so make sure you have the driver for your particular database of
	| choice installed on your machine before you begin development.
	|
	*/

	'connections' => array(

		'mysql' => array(
			'driver'    => 'mysql',
			'host'      => 'localhost',
			'database'  => 'atg_dev',
			'username'  => 'atg_dev',
			'password'  => '***REMOVED***',
			'charset'   => 'utf8',
			'collation' => 'utf8_unicode_ci',
			'prefix'    => '',
		),

		'old' => array(
			'driver'    => 'mysql',
			'host'      => 'localhost',
			'database'  => 'atg_old',
			'username'  => 'atg_dev',
			'password'  => '***REMOVED***',
			'charset'   => 'utf8',
			'collation' => 'utf8_unicode_ci',
			'prefix'    => '',
		),

		'phpbb' => array(
			'driver'    => 'mysql',
			'host'      => 'localhost',
			'database'  => 'atg_phpbb',
			'username'  => 'atg_phpbb',
			'password'  => '***REMOVED***',
			'charset'   => 'utf8',
			'collation' => 'utf8_unicode_ci',
			'prefix'    => '',
		),
	),
);