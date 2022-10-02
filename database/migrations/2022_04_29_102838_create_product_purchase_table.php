<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductPurchaseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_purchase', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('purchase_id')->index('product_purchase_purchase_id_foreign');
            $table->unsignedBigInteger('product_id')->index('product_purchase_product_id_foreign');
            $table->unsignedBigInteger('supplier_id');
            $table->integer('qty');
            $table->float('price', 16)->default(0);
            $table->float('sales_price', 16)->default(0);
            $table->float('cost', 16)->default(0);
            $table->dateTime('purchased_at');
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
        Schema::dropIfExists('product_purchase');
    }
}
