<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyMailkitFiltersTableAddRuleRef extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mailkit_filters', function (Blueprint $table) {
            //
            $table->unsignedInteger('rule_id')->nullable()->default(null);
            $table->foreign('rule_id')->references('id')->on('mailkit_rules')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mailkit_filters', function (Blueprint $table) {
            //
            $table->dropForeign('rule_id');
        });
    }
}
