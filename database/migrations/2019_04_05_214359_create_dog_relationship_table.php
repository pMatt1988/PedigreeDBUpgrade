<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDogRelationshipTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dog_relationship', function (Blueprint $table) {
            $table->primary(['dog_id', 'relation']);
            $table->unsignedInteger('dog_id');
            $table->unsignedInteger('parent_id');
            $table->string('relation', 8);
            $table->timestamps();

            $table->foreign('dog_id')->references('id')->on('dogs')->onDelete('cascade');
            $table->foreign('parent_id')->references('id')->on('dogs')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dog_relationship');
    }
}
