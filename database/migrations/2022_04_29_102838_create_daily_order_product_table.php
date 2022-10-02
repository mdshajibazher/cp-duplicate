<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDailyOrderProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_order_product', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('daily_order_id')->index('daily_order_product_daily_order_id_foreign');
            $table->unsignedBigInteger('user_id')->index('daily_order_product_user_id_foreign');
            $table->unsignedBigInteger('product_id')->index('daily_order_product_product_id_foreign');
            $table->integer('qty');
            $table->integer('price');
            $table->dateTime('date');
            $table->unsignedBigInteger('admin_id')->index('daily_order_product_admin_id_foreign');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('daily_order_product');
    }
}
