<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->integer('user_id')->unsigned()->nullable()->change();
            $table->integer('edit_user_id')->unsigned()->nullable()->change();
        });

        DB::table('articles')
            ->where('edit_user_id', '=', 0)
            ->update(['edit_user_id' => null]);

        Schema::table('articles', function (Blueprint $table) {
            $table->foreign('user_id', 'user_foreign_key')
                ->references('id')
                ->on('users');

            $table->foreign('edit_user_id', 'edit_user_foreign_key')
                ->references('id')
                ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropForeign('user_foreign_key');
            $table->dropForeign('edit_user_foreign_key');
        });
    }
}
