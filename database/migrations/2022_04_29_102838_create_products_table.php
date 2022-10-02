<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('product_name', 191);
            $table->string('image', 191)->default('product.jpg');
            $table->double('price', 14, 2);
            $table->double('discount_price', 14, 2)->nullable();
            $table->double('current_price', 14, 2)->nullable();
            $table->float('tp', 14)->default(0);
            $table->unsignedBigInteger('brand_id')->index('products_brand_id_foreign');
            $table->text('description')->nullable();
            $table->integer('size_id');
            $table->string('type', 191);
            $table->boolean('in_stock')->default(false);
            $table->date('mfg')->nullable();
            $table->date('exp')->nullable();
            $table->boolean('discontinued')->default(false);
            $table->softDeletes();
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
        Schema::dropIfExists('products');
    }
}
