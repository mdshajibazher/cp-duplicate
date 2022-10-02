<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cashes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->double('amount', 14, 2);
            $table->float('discount', 16)->default(0);
            $table->unsignedBigInteger('user_id')->index('cashes_user_id_foreign');
            $table->string('reference', 191)->nullable();
            $table->unsignedBigInteger('paymentmethod_id')->index('cashes_paymentmethod_id_foreign');
            $table->string('posted_by', 191);
            $table->dateTime('received_at');
            $table->integer('status')->default(0);
            $table->integer('approved_by')->nullable();
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
        Schema::dropIfExists('cashes');
    }
}
