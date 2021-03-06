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
        Schema::create('daily_attendances', function (Blueprint $table) {
            $table->id();
            $table->string('key');
            $table->integer('class_id')->nullable();
            $table->integer('user_id');
            $table->integer('lesson_id')->nullable();
            $table->dateTime('date');
            $table->string('status')->nullable();
            $table->boolean('at_lesson');
            $table->boolean('processed_by')->nullable();
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
        Schema::dropIfExists('daily_attendances');
    }
};
