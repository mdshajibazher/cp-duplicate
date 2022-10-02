<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDailyOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date');
            $table->double('amount', 18, 2);
            $table->double('discount', 16, 2);
            $table->double('shipping', 16, 2);
            $table->unsignedBigInteger('user_id')->index('daily_orders_user_id_foreign');
            $table->text('references')->nullable();
            $table->unsignedBigInteger('admin_id')->index('daily_orders_admin_id_foreign');
            $table->tinyInteger('status')->default(0);
            $table->string('approved_by', 191)->nullable();
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
        Schema::dropIfExists('daily_orders');
    }
}
