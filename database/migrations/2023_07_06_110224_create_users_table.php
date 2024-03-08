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
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('name_arabic', 255)->nullable();
            $table->mediumText('user_slug')->nullable();
            $table->string('first_name', 255)->nullable();
            $table->string('middle_name', 255)->nullable();
            $table->string('last_name', 255)->nullable();
            $table->string('designation', 255)->nullable();
            $table->mediumText('photo')->nullable();
            $table->integer('user_approved')->default(3)->comment('1 -- Approved, 2 -- Rejected, 3 -- Pending');
            $table->string('username', 255);
            $table->string('email', 255);
            $table->timestamp('email_verified_at')->nullable();
            $table->integer('is_email_verified')->nullable()->default(2);
            $table->string('password');
            $table->string('api_token', 255)->nullable();
            $table->rememberToken();
            $table->integer('status')->nullable()->default(2);
            $table->integer('is_admin')->default(2)->comment('2 = No | 1 = Yes');
            $table->integer('is_super_admin')->default(2);
            $table->integer('is_backend_user')->default(2);
            $table->integer('is_system_account')->default(2);
            $table->integer('force_password_change')->default(2);
            $table->integer('password_changed')->default(2);
            $table->dateTime('last_logged_in')->nullable();
            $table->string('user_validate_code')->nullable();
            $table->string('phone_number', 255)->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
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
        Schema::dropIfExists('users');
    }
};
