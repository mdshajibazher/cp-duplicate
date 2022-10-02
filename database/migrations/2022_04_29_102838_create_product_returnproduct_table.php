<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductReturnproductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_returnproduct', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('product_id')->index('product_returnproduct_product_id_foreign');
            $table->unsignedBigInteger('returnproduct_id')->index('product_returnproduct_returnproduct_id_foreign');
            $table->unsignedBigInteger('user_id')->index('product_returnproduct_user_id_foreign');
            $table->integer('qty');
            $table->string('price', 191);
            $table->dateTime('returned_at');
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
        Schema::dropIfExists('product_returnproduct');
    }
}
