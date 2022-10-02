<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToProductReturnproductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_returnproduct', function (Blueprint $table) {
            $table->foreign(['product_id'])->references(['id'])->on('products')->onDelete('CASCADE');
            $table->foreign(['user_id'])->references(['id'])->on('users')->onDelete('CASCADE');
            $table->foreign(['returnproduct_id'])->references(['id'])->on('returnproducts')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_returnproduct', function (Blueprint $table) {
            $table->dropForeign('product_returnproduct_product_id_foreign');
            $table->dropForeign('product_returnproduct_user_id_foreign');
            $table->dropForeign('product_returnproduct_returnproduct_id_foreign');
        });
    }
}
