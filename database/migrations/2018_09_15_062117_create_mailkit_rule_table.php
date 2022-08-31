<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMailkitRuleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mailkit_rules', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->unsignedInteger('weight')->default(1);
            $table->text('recipient_list');
            $table->unsignedInteger('counter')->default(0);
            $table->unsignedInteger('counter_total')->default(0);
            $table->boolean('enabled')->default(true);
            $table->timestamps();
            $table->softDeletes();

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
        Schema::dropIfExists('mailkit_rules');
    }
}
