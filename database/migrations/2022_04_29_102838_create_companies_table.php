<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('company_name', 191)->default('Example Company');
            $table->text('address')->nullable();
            $table->string('email', 191)->default('info@example.com');
            $table->string('phone', 191)->default('01xxxxxxxxx');
            $table->string('bin', 191)->default('b54000000000');
            $table->string('social', 191)->default('{"facebook":["#","1"],"twitter":["#","1"],"pinterest":["#","1"],"linkedin":["#","1"]}');
            $table->string('logo', 191)->default('vcl.png');
            $table->string('favicon', 191)->default('favicon.png');
            $table->string('og_image', 191)->default('og.png');
            $table->string('tagline', 191)->nullable();
            $table->text('short_description')->nullable();
            $table->text('map_embed')->nullable();
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
        Schema::dropIfExists('companies');
    }
}
