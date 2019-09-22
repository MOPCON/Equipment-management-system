<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateBotMessageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bot_message_channels', function (Blueprint $table) {
            $table->unsignedInteger('bot_message_id');
            $table->unsignedInteger('bot_channel_id');
            $table->unsignedInteger('status')->default(0);
            $table->primary(['bot_message_id', 'bot_channel_id']);
        });

        Schema::table('bot_messages', function (Blueprint $table) {
            $table->unsignedInteger('channel_id')->nullable()->change();
        });

        Schema::table('bot_channels', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('bot_message_channels');
        Schema::table('bot_channels', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('bot_messages', function (Blueprint $table) {
            $table->unsignedInteger('channel_id')->change();
        });
    }
}
