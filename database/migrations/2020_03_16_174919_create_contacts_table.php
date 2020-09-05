<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('company_id');
            $table->unsignedBigInteger('campaign_id')->nullable();
            $table->unsignedInteger('contact_list_id')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->tinyInteger('dial_code')->default(1);
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->text('other')->nullable();
            $table->text('data')->nullable();
            $table->enum('status', ['contact', 'campaign', 'owner'])->default('contact');
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
        Schema::dropIfExists('contacts');
    }
}
