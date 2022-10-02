<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->dateTime('expense_date');
            $table->string('reasons', 191);
            $table->double('amount', 16, 2);
            $table->unsignedBigInteger('admin_id')->index('expenses_admin_id_foreign');
            $table->unsignedBigInteger('expensecategory_id')->index('expenses_expensecategory_id_foreign');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('expenses');
    }
}
