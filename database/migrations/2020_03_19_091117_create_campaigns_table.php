<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->enum('type', ['email', 'sms', 'voice']);
            $table->integer('reward_value')->default(0);
            $table->string('chat_purpose')->default('sales');
            $table->timestamp('end_date')->nullable();
            $table->string('name');
            $table->enum('status',['draft','active', 'completed'])->default('draft');
            $table->boolean('prebuilt')->default(false);
            $table->boolean('has_paid_owner')->default(false);
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
        Schema::dropIfExists('campaigns');
    }
}
