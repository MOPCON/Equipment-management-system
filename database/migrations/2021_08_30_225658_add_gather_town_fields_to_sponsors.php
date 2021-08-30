<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGatherTownFieldsToSponsors extends Migration
{
    public function up()
    {
        Schema::table('sponsors', function (Blueprint $table) {
            $table->string('promotion_gather_town_h_link')->nullable()->comment('Gather Town 橫式圖片')->after('promotion_email_image');
            $table->string('promotion_gather_town_v_link')->nullable()->comment('Gather Town 直式圖片')->after('promotion_email_image');
            $table->string('promotion_gather_town_video_link')->nullable()->comment('Gather Town 宣傳影片')->after('promotion_email_image');
        });
    }

    public function down()
    {
        Schema::table('sponsors', function (Blueprint $table) {
            $table->dropColumn('promotion_gather_town_h_link');
            $table->dropColumn('promotion_gather_town_v_link');
            $table->dropColumn('promotion_gather_town_video_link');
        });
    }
}
