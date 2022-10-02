<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 191);
            $table->string('inventory_email', 191)->nullable()->unique();
            $table->string('phone', 191)->nullable();
            $table->text('address')->nullable();
            $table->string('company', 191)->nullable();
            $table->unsignedBigInteger('division_id')->nullable()->default('6')->index('users_division_id_foreign');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password', 191)->nullable();
            $table->string('user_type', 191)->default('ecom');
            $table->string('image', 191)->default('user.jpg');
            $table->boolean('status')->default(true);
            $table->text('pricedata')->nullable();
            $table->unsignedBigInteger('section_id')->default('3')->index('users_section_id_foreign');
            $table->boolean('sub_customer')->default(true);
            $table->text('sub_customer_json')->nullable();
            $table->boolean('sms_alert')->default(true);
            $table->boolean('login_access')->default(false);
            $table->softDeletes();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
