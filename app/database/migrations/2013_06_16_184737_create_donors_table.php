<?php

use Illuminate\Database\Migrations\Migration;

class CreateDonorsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('donors', function($t)
		{
			$t->increments('id');
			$t->string('email');
			$t->string('first_name');
			$t->string('last_name');
			$t->string('steam_id')->nullable();
			$t->string('ingame_name')->nullable();
			$t->string('payer_id');
			$t->timestamp('expires_at');
			$t->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('donors');
	}

}