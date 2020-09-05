<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVideoRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('video_rooms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid');
            $table->text('token')->nullable();
            $table->string('name');
            $table->enum('status', ['available', 'terminated'])->default('available');
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
        Schema::dropIfExists('video_rooms');
    }
}
