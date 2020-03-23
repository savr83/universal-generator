<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMailkitSourceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mailkit_sources', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('connection');
            $table->string('login');
            $table->string('password');
            $table->boolean('enabled')->default(true);
            $table->timestamps();
            $table->string('lastmail_id');

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
        Schema::dropIfExists('mailkit_sources');
    }
}
