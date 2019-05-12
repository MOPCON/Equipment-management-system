<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddESTAndASTToTelegramMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('telegram_messages', function (Blueprint $table) {
            $table->dateTime('sending_time')->nullable()->change()->comment = '預計發送時間';
            $table->renameColumn('sending_time', 'es_time');
            $table->dateTime('as_time')->nullable()->after('sending_time')->comment = '實際發送時間';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('telegram_messages', function (Blueprint $table) {
            $table->renameColumn('es_time', 'sending_time');
            $table->dropColumn('as_time');
        });
    }
}
