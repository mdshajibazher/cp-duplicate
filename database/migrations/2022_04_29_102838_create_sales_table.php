<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->index('sales_user_id_foreign');
            $table->double('discount', 10, 2);
            $table->double('carrying_and_loading', 10, 2);
            $table->dateTime('sales_at');
            $table->double('amount', 14, 2)->nullable();
            $table->integer('sales_status');
            $table->string('provided_by', 191)->nullable();
            $table->integer('approved_by')->nullable();
            $table->boolean('edited')->default(false);
            $table->text('changes_text')->nullable();
            $table->integer('delivery_status')->default(0);
            $table->integer('delivery_marked_by')->nullable();
            $table->text('deliveryinfo')->nullable();
            $table->boolean('is_condition')->default(false);
            $table->double('condition_amount', 16, 2)->nullable()->default(0);
            $table->dateTime('delivered_at')->nullable();
            $table->text('reference')->nullable();
            $table->boolean('cust_sms')->default(false);
            $table->boolean('d_agent_sms')->default(false);
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
        Schema::dropIfExists('sales');
    }
}
