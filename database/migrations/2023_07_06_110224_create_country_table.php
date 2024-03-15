<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('country', function (Blueprint $table) {
            $table->integer('country_id', true);
            $table->string('iso', 2)->nullable();
            $table->string('name', 128)->nullable();
            $table->string('country_name', 128)->nullable();
            $table->mediumText('country_name_arabic')->nullable();
            $table->string('country_region')->nullable();
            $table->string('iso3', 5)->nullable();
            $table->string('currency_name')->nullable();
            $table->string('iso_4217')->nullable();
            $table->integer('numcode')->nullable();
            $table->integer('phonecode')->nullable();
            $table->integer('country_status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('country');
    }
};
