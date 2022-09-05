<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AdjustSummaryLengthFor2022Speakers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('speakers', function (Blueprint $table) {
            $table->string('summary', 1000)->change();
            $table->string('summary_e', 1500)->change();
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
            $table->string('summary', 480)->change();
            $table->string('summary_e', 1000)->change();
        });
    }
}
