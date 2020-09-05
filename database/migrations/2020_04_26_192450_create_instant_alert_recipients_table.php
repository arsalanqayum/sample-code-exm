<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstantAlertRecipientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('instant_alert_recipients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('instant_alert_id');
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
        Schema::dropIfExists('instant_alert_recipients');
    }
}
