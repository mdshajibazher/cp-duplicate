<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReturnproductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('returnproducts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->index('returnproducts_user_id_foreign');
            $table->double('discount', 10, 2);
            $table->double('carrying_and_loading', 10, 2);
            $table->double('amount', 14, 2);
            $table->dateTime('returned_at');
            $table->string('type', 191);
            $table->string('returned_by', 191)->nullable();
            $table->integer('return_status')->default(0);
            $table->integer('approved_by')->nullable();
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
        Schema::dropIfExists('returnproducts');
    }
}
