<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToSupplierduesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('supplierdues', function (Blueprint $table) {
            $table->foreign(['admin_id'])->references(['id'])->on('admins');
            $table->foreign(['supplier_id'])->references(['id'])->on('suppliers')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('supplierdues', function (Blueprint $table) {
            $table->dropForeign('supplierdues_admin_id_foreign');
            $table->dropForeign('supplierdues_supplier_id_foreign');
        });
    }
}
