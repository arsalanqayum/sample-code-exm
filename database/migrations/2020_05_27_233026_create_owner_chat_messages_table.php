<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOwnerChatMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('owner_chat_messages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('owner_chat_id');
            $table->text('body');
            $table->enum('from', ['owner', 'buyer']);
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
        Schema::dropIfExists('owner_chat_messages');
    }
}
