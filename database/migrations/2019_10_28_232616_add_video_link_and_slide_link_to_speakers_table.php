<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddVideoLinkAndSlideLinkToSpeakersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('speakers', function (Blueprint $table) {
            $table->string('link_slide')->nullable()->after('link_other');
            $table->string('link_video')->nullable()->after('link_other');
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
            $table->dropColumn('link_slide');
            $table->dropColumn('link_video');
        });
    }
}
