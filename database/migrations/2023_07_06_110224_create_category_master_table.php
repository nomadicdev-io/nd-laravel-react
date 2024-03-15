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
        Schema::create('category_master', function (Blueprint $table) {
            $table->integer('category_id', true);
            $table->integer('category_parent_id')->nullable()->default(0);
            $table->string('category_title');
            $table->string('category_title_arabic')->nullable();
            $table->string('category_slug');
            $table->integer('category_priority')->nullable()->default(1);
            $table->dateTime('category_created_at');
            $table->dateTime('category_updated_at');
            $table->integer('category_created_by');
            $table->integer('category_updated_by');
            $table->softDeletes();
            $table->integer('category_status')->default(2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category_master');
    }
};
