<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->enum('communication_type', ['sms', 'sms-and-video'])->default('sms');
            $table->string('timezone')->nullable();
            $table->enum('gender', ['male', 'female']);
            $table->string('age_range');
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('language');
            $table->string('zip_code');
            $table->string('address');
            $table->string('time_to_chat');
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
        Schema::dropIfExists('user_profiles');
    }
}
