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
        Schema::create('posts', function (Blueprint $table) {
            $table->integer('post_id', true);
            $table->mediumText('post_slug');
            $table->string('post_type')->nullable();
            $table->string('post_media_type')->default('');
            $table->integer('post_parent_id')->nullable();
            $table->integer('post_category_id')->nullable();
            $table->integer('post_sub_category_id')->nullable()->index('post_sub_category_id');
            $table->mediumText('post_title')->nullable();
            $table->mediumText('post_title_arabic')->nullable();
            $table->string('post_image')->nullable();
            $table->string('post_image_arabic')->nullable();
            $table->integer('post_status');
            $table->integer('post_priority')->nullable();
            $table->integer('post_country')->nullable();
            $table->integer('post_year')->nullable();
            $table->integer('post_seo_parent_id')->nullable();
            $table->string('post_lang', 195)->nullable();
            $table->integer('post_set_as_banner')->nullable()->default(2)->comment('1- yes 2-no');
            $table->dateTime('post_created_datetime')->nullable();
            $table->dateTime('post_updated_datetime')->nullable();
            $table->integer('post_created_by');
            $table->integer('post_updated_by');
            $table->dateTime('post_created_at');
            $table->dateTime('post_updated_at');
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
        Schema::dropIfExists('posts');
    }
};
