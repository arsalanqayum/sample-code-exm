<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecipientStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recipient_statuses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sequence_type_id');
            $table->unsignedBigInteger('contact_id');
            $table->enum('status', ['pending', 'failed', 'sent'])->default('pending');
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
        Schema::dropIfExists('recipient_statuses');
    }
}
