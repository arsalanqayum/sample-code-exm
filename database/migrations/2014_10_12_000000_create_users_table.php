<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->tinyInteger('dial_code')->default(1);
            $table->string('phone')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('type')->default('owner');
            $table->string('status')->default('active');
            $table->boolean('is_verified')->default(false);
            $table->string('photo')->default('profile.png');
            $table->string('chat_status')->default('available');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
