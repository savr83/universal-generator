<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProcessingLogicAndValidationRule extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fields', function (Blueprint $table) {
            $table->renameColumn('rule', 'validation_rule')->nullable()->change();
            $table->text('default')->nullable()->change();
            $table->text('processing_logic')->nullable();
        });
        Schema::table('rules', function (Blueprint $table) {
            $table->renameColumn('logic', 'processing_logic')->nullable()->change();
            $table->text('validation_rule')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fields', function (Blueprint $table) {
            $table->renameColumn('validation_rule', 'rule');
            $table->dropColumn('processing_logic');
        });
        Schema::table('rules', function (Blueprint $table) {
            $table->renameColumn('processing_logic', 'logic');
            $table->dropColumn('validation_rule');
        });
    }
}
