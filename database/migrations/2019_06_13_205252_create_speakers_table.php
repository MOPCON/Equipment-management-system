<?php

use App\Speaker;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpeakersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('speakers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('name_e')->nullable();
            $table->string('company')->nullable();
            $table->string('job_title')->nullable();
            $table->string('bio', 120)->nullable();
            $table->string('bio_e', 240)->nullable();
            $table->string('photo')->nullable();
            $table->string('link_fb')->nullable();
            $table->string('link_github')->nullable();
            $table->string('link_twitter')->nullable();
            $table->string('link_other')->nullable();
            $table->string('topic', 32)->nullable();
            $table->string('topic_e', 64)->nullable();
            $table->string('summary', 240)->nullable();
            $table->string('summary_e', 480)->nullable();
            $table->text('tag')->nullable();
            $table->tinyInteger('level')->nullable();
            $table->tinyInteger('license')->nullable();
            $table->boolean('promotion')->nullable();
            $table->tinyInteger('tshirt_size')->nullable();
            $table->boolean('need_parking_space')->nullable();
            $table->boolean('has_dinner')->nullable();
            $table->tinyInteger('meal_preference')->nullable();
            $table->tinyInteger('has_companion')->nullable();
            $table->uuid('access_key')->index();
            $table->string('access_secret', 20);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('speakers');
    }
}
