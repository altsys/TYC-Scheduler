<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->enum('type', ['meeting', 'conference', 'lecture', 'exam']);
            $table->tinyInteger('priority')->unsigned()->default(1)->comment('1 the lowest, 3 the highest');
            $table->tinyInteger('frequency')->unsigned()->comment('0 one time, 1 yearly, 2 qourterly, 3 monthly, 4 weekly, 5 daily');
            $table->timestamps();

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}
