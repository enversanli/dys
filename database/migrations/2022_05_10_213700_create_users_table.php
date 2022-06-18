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
            $table->increments('id');
            $table->string('key');
            $table->integer('role_id');
            $table->integer('association_id')->nullable();
            $table->integer('parent_id')->nullable();
            $table->integer('class_id')->nullable();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('gender')->nullable();
            $table->integer('mobile_phone')->nullable();
            $table->integer('phone')->nullable();
            $table->string('email');
            $table->string('password');
            $table->dateTime('email_verified_at')->nullable();
            $table->text('reset_password_code')->nullable();
            $table->string('status')->default(\App\Support\Enums\UserStatusEnum::MAIL_VERIFICATION->value);
            $table->string('photo_url')->nullable();
            $table->dateTime('birth_date')->nullable();
            $table->string('time_zone')->nullable();
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
