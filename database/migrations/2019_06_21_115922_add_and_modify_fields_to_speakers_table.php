<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAndModifyFieldsToSpeakersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('speakers', function (Blueprint $table) {
            $table->tinyInteger('speaker_status')->nullable()->after('has_companion');
            $table->tinyInteger('speaker_type')->nullable()->after('speaker_status');
            $table->text('note')->nullable()->after('speaker_type');
            $table->string('last_edited_by')->default('')->after('note');
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
            $table->dropColumn('speaker_status');
            $table->dropColumn('speaker_type');
            $table->dropColumn('note');
            $table->dropColumn('last_edited_by');
        });
    }
}
