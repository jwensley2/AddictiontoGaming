<?php

use Illuminate\Database\Migrations\Migration;

class CreateDonationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('donations', function($t)
		{
			$t->increments('id');
			$t->integer('donor_id');
			$t->string('txn_id');
			$t->decimal('fee', 6, 2);
			$t->decimal('gross', 6, 2);
			$t->string('status');
			$t->string('type');
			$t->timestamps();

			// Keys
			$t->index('donor_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('donations');
	}

}