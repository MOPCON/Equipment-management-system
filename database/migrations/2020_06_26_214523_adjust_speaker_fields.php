<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AdjustSpeakerFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('speakers', function (Blueprint $table) {
            $table->boolean('agree_record')->nullable()->after('level')->comment="授與錄影";
            $table->string('real_name')->nullable()->after('name_e')->comment="真實姓名";
            $table->string('contact_email')->nullable()->after('job_title_e')->comment="聯絡Email";
            $table->string('contact_phone')->nullable()->after('contact_email')->comment="聯絡電話";
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
            $table->dropColumn('agree_record');
            $table->dropColumn('real_name');
            $table->dropColumn('contact_email');
            $table->dropColumn('contact_phone');
        });
    }
}
