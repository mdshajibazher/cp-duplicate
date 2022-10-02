<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('supplier_id')->index('purchases_supplier_id_foreign');
            $table->double('discount', 10, 2);
            $table->double('carrying_and_loading', 10, 2);
            $table->dateTime('purchased_at');
            $table->float('cost', 16)->default(0);
            $table->double('amount', 14, 2)->nullable();
            $table->unsignedBigInteger('warehouse_id')->default('1');
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
        Schema::dropIfExists('purchases');
    }
}
