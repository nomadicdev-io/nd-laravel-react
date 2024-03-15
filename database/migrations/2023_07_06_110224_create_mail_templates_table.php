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
        Schema::create('mail_templates', function (Blueprint $table) {
            $table->integer('mt_id', true);
            $table->string('mt_title', 255);
            $table->string('mt_slug', 255);
            $table->mediumText('mt_subject');
            $table->mediumText('mt_subject_arabic')->nullable();
            $table->longText('mt_template');
            $table->longText('mt_template_arabic')->nullable();
            $table->dateTime('mt_created_at');
            $table->dateTime('mt_updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mail_templates');
    }
};
