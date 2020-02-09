<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDogHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dog_history', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('dog_id');
            $table->unsignedInteger('sire_id');
            $table->unsignedInteger('dam_id');
            $table->longText('model');
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
        Schema::dropIfExists('dog_history');
    }
}
