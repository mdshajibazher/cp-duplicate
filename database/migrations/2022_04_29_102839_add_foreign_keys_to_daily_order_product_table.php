<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToDailyOrderProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('daily_order_product', function (Blueprint $table) {
            $table->foreign(['user_id'])->references(['id'])->on('users')->onDelete('CASCADE');
            $table->foreign(['admin_id'])->references(['id'])->on('admins');
            $table->foreign(['product_id'])->references(['id'])->on('products')->onDelete('CASCADE');
            $table->foreign(['daily_order_id'])->references(['id'])->on('daily_orders')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('daily_order_product', function (Blueprint $table) {
            $table->dropForeign('daily_order_product_user_id_foreign');
            $table->dropForeign('daily_order_product_admin_id_foreign');
            $table->dropForeign('daily_order_product_product_id_foreign');
            $table->dropForeign('daily_order_product_daily_order_id_foreign');
        });
    }
}
