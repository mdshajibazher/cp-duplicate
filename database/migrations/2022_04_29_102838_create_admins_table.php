<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 191);
            $table->string('adminname', 191)->nullable();
            $table->string('email', 191)->nullable();
            $table->string('phone', 191)->unique();
            $table->string('image', 191)->default('default.png');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password', 191);
            $table->string('signature', 191)->nullable();
            $table->rememberToken();
            $table->tinyInteger('status')->default(1);
            $table->integer('user_id')->nullable();
            $table->boolean('password_changed')->default(true);
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
        Schema::dropIfExists('admins');
    }
}
