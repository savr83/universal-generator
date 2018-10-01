<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyMailkitSourcesTableAddLastmailId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mailkit_sources', function (Blueprint $table) {
            $table->string('lastmail_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mailkit_sources', function (Blueprint $table) {
            $table->dropColumn('lastmail_id');
        });
    }
}
