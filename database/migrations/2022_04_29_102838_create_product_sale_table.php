<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductSaleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_sale', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('product_id')->index('product_sale_product_id_foreign');
            $table->unsignedBigInteger('sale_id')->index('product_sale_sale_id_foreign');
            $table->unsignedBigInteger('user_id')->index('product_sale_user_id_foreign');
            $table->integer('qty');
            $table->integer('free')->default(0);
            $table->string('price', 191);
            $table->dateTime('sales_at');
            $table->unsignedBigInteger('warehouse_id')->default('1');
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
        Schema::dropIfExists('product_sale');
    }
}
