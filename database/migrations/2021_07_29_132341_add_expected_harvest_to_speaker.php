<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddExpectedHarvestToSpeaker extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('speakers', function (Blueprint $table) {
            $table->boolean('agree_act_change')->default(false)->change();
            $table->string('expected_harvest', 120)->nullable()->after('prerequisites')->comment = "預期收穫";
            $table->boolean('agree_pre_video_public')->nullable()->default(false)->after('agree_act_change')->comment = "同意且知悉活動結束後七天內，預錄影片會放在 Youtube 供會眾觀看";
            $table->boolean('agree_record_qa')->nullable()->default(false)->after('agree_pre_video_public')->comment = "同意 Q&A 階段進行錄影";
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
            $table->boolean('agree_act_change')->default(null)->change();
            $table->dropColumn('expected_harvest');
            $table->dropColumn('agree_pre_video_public');
            $table->dropColumn('agree_record_qa');
        });
    }
}
