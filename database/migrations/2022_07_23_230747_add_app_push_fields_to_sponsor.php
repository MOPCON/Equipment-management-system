<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAppPushFieldsToSponsor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sponsors', function (Blueprint $table) {
            $table->text('promotion_app_push_image_link')->nullable()->comment('大會 App 推播訊息圖片')->after('promotion_gather_town_video_link');
            $table->text('promotion_app_push_title')->nullable()->comment('大會 App 推播訊息標題')->after('promotion_app_push_image_link');
            $table->text('promotion_app_push_content')->nullable()->comment('大會 App 推播訊息內文')->after('promotion_app_push_title');
            $table->text('promotion_app_push_link')->nullable()->comment('大會 App 推播訊息跳轉連結')->after('promotion_app_push_content');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sponsors', function (Blueprint $table) {
            $table->dropColumn('promotion_app_push_image_link');
            $table->dropColumn('promotion_app_push_title');
            $table->dropColumn('promotion_app_push_content');
            $table->dropColumn('promotion_app_push_link');
        });
    }
}
