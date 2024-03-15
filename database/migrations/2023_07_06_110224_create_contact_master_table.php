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
        Schema::create('contact_master', function (Blueprint $table) {
            $table->integer('cm_id', true);
            $table->mediumText('user_agent_string')->nullable();
            $table->string('cm_name', 255);
            $table->string('cm_email_address', 255);
            $table->string('cm_phone_number', 255);
            $table->integer('cm_subject');
            $table->mediumText('cm_message');
            $table->dateTime('cm_created_at')->nullable()->useCurrent();
            $table->dateTime('cm_updated_at')->nullable()->useCurrent();
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
        Schema::dropIfExists('contact_master');
    }
};
