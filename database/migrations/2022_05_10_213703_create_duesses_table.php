<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDuessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('duesses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('dues_type_id')->nullable();
            $table->integer('status')->nullable();
            $table->integer('year');
            $table->integer('month');
            $table->integer('fee')->nullable();
            $table->dateTime('paid_at')->nullable();
            $table->integer('approved_by')->nullable();
            $table->dateTime('approved_at')->nullable();
            $table->integer('cancelled_by')->nullable();
            $table->string('message')->nullable();
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
        Schema::dropIfExists('duesses');
    }
}
