<?php

use Illuminate\Database\Migrations\Migration;

class CleanupOldTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::dropIfExists('donations');
		Schema::dropIfExists('donators');
		Schema::dropIfExists('news');
		Schema::dropIfExists('players');
		Schema::dropIfExists('players_of_the_week');
		Schema::dropIfExists('servers');
		Schema::dropIfExists('settings');
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
	}

}