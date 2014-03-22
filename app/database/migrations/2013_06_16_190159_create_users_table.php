<?php

use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function($t)
		{
			$t->increments('id');
			$t->integer('group_id');
			$t->string('email');
			$t->string('username');
			$t->string('password', 60);
			$t->boolean('active');
			$t->boolean('founder');
			$t->timestamps();

			// Keys
			$t->unique('email');
			$t->unique('username');
			$t->index('group_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
	}

}