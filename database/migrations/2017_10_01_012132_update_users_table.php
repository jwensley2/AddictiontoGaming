<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('group_id')->nullable()->unsigned()->change();
            $table->boolean('active')->default(0)->change();
            $table->boolean('founder')->default(0)->change();

            $table->rememberToken()->change();

            $table->foreign('group_id')
                ->references('id')
                ->on('groups');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('users_group_id_foreign');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->integer('group_id')->change();
            $table->boolean('active')->change();
            $table->boolean('founder')->change();
        });
    }
}
