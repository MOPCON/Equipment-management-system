<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTaAndExpectedHarvestEnFieldsToSpeakers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('speakers', function (Blueprint $table) {
            $table->string('target_audience_e', 1000)->nullable()->comment('目標會眾(英文)')->after('target_audience');
            $table->string('expected_harvest_e', 1000)->nullable()->comment('預期收穫(英文)')->after('expected_harvest');
            $table->string('prerequisites_e', 1000)->nullable()->comment('先備知識(英文)')->after('prerequisites');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('speakers', function (Blueprint $table) {
            $table->dropColumn('target_audience_e');
            $table->dropColumn('expected_harvest_e');
            $table->dropColumn('prerequisites_e');
        });
    }
}
