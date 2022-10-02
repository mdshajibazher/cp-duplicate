<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToDailyOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('daily_orders', function (Blueprint $table) {
            $table->foreign(['admin_id'])->references(['id'])->on('admins');
            $table->foreign(['user_id'])->references(['id'])->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('daily_orders', function (Blueprint $table) {
            $table->dropForeign('daily_orders_admin_id_foreign');
            $table->dropForeign('daily_orders_user_id_foreign');
        });
    }
}
