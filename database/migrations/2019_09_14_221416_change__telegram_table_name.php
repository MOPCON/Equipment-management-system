<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeTelegramTableName extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('telegram_channels', 'bot_channels');
        Schema::rename('telegram_messages', 'bot_messages');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::rename('bot_channels', 'telegram_channels');
        Schema::rename('bot_messages', 'telegram_messages');
    }
}
