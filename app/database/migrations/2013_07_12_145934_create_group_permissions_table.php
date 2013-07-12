<?php

use Illuminate\Database\Migrations\Migration;

class CreateGroupPermissionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('group_permissions', function($t) {
			$t->integer('group_id');
			$t->integer('permission_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('group_permissions');
	}

}