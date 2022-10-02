<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupplierduesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supplierdues', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->double('amount', 14, 2);
            $table->unsignedBigInteger('supplier_id')->index('supplierdues_supplier_id_foreign');
            $table->string('reference', 191);
            $table->unsignedBigInteger('admin_id')->index('supplierdues_admin_id_foreign');
            $table->dateTime('due_at');
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
        Schema::dropIfExists('supplierdues');
    }
}
