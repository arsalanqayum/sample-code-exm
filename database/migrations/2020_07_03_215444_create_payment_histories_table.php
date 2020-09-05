<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('payment_historiable_id');
            $table->string('payment_historiable_type');
            $table->string('uniqid')->nullable();
            $table->bigInteger('amount')->default(0);
            $table->string('currency')->default('usd');
            $table->string('type')->nullable();
            $table->string('status')->default('no_status');
            $table->string('description')->nullable();
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
        Schema::dropIfExists('payment_histories');
    }
}
