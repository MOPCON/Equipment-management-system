<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToSponsor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sponsors', function (Blueprint $table) {
            $table->text('promotion_ad_media_link')->nullable()->after('remark');
            $table->text('promotion_warm_up_media_link')->nullable()->after('remark');
            $table->text('promotion_discord_intro')->nullable()->after('remark');
            $table->text('promotion_email_short')->nullable()->after('remark');
            $table->string('promotion_email_url')->nullable()->after('remark');
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
            $table->dropColumn('promotion_ad_media_link');
            $table->dropColumn('promotion_warm_up_media_link');
            $table->dropColumn('promotion_discord_intro');
            $table->dropColumn('promotion_email_short');
            $table->dropColumn('promotion_email_url');
        });
    }
}
