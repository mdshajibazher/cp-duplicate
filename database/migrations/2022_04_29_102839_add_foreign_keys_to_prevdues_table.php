<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToPrevduesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('prevdues', function (Blueprint $table) {
            $table->foreign(['admin_id'])->references(['id'])->on('admins');
            $table->foreign(['user_id'])->references(['id'])->on('users')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('prevdues', function (Blueprint $table) {
            $table->dropForeign('prevdues_admin_id_foreign');
            $table->dropForeign('prevdues_user_id_foreign');
        });
    }
}
