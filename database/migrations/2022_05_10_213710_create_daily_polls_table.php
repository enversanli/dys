<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDailyPollsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_attendance', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('association_id')->nullable();
            $table->integer('class_id')->nullable();
            $table->integer('lesson_id')->nullable();
            $table->integer('user_id');
            $table->dateTime('date');
            $table->string('status')->nullable();
            $table->string('note')->nullable();
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
        Schema::dropIfExists('daily_polls');
    }
}
