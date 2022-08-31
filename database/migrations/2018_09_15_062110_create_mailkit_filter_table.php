<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMailkitFilterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mailkit_filters', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('mail_field');
            $table->string('regexp');
            $table->string('action');
            $table->boolean('enabled')->default(true);
            $table->timestamps();

            $table->unsignedInteger('pool_id');
            $table->foreign('pool_id')->references('id')->on('mailkit_pools')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mailkit_filters');
    }
}
