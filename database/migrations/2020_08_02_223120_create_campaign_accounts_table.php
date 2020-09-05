<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaignAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaign_accounts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('campaign_id');
            $table->unsignedBigInteger('user_id');
            $table->string('status')->default('pending');
            $table->bigInteger('earning')->default(0);
            $table->string('currency')->default('usd');
            $table->boolean('paid')->default(false);
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
        Schema::dropIfExists('campaign_accounts');
    }
}
