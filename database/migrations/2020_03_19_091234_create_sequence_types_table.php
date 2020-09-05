<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSequenceTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sequence_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('campaign_id');
            $table->unsignedBigInteger('template_id');
            $table->timestamp('start_date')->nullable();
            $table->integer('prebuilt_start_day_after')->nullable();
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
        Schema::dropIfExists('sequence_types');
    }
}
