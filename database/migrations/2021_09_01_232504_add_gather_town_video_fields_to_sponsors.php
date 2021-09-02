<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGatherTownVideoFieldsToSponsors extends Migration
{
    public function up()
    {
        Schema::table('sponsors', function (Blueprint $table) {
            $table->string('promotion_gather_town_video_link_0')->nullable()->comment('Gather Town 宣傳影片 2')->after('promotion_gather_town_video_link');
            $table->string('promotion_gather_town_video_link_1')->nullable()->comment('Gather Town 宣傳影片 3')->after('promotion_gather_town_video_link');
        });
    }

    public function down()
    {
        Schema::table('sponsors', function (Blueprint $table) {
            $table->string('promotion_gather_town_video_link_0');
            $table->string('promotion_gather_town_video_link_1');
        });
    }
}
