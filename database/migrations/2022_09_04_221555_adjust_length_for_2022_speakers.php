<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AdjustLengthFor2022Speakers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('speakers', function (Blueprint $table) {
            $table->string('bio', 240)->change();
            $table->string('target_audience', 500)->change();
            $table->string('expected_harvest', 500)->change();
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
            $table->string('bio', 120)->change();
            $table->string('target_audience', 64)->change();
            $table->string('expected_harvest', 120)->change();
        });
    }
}
