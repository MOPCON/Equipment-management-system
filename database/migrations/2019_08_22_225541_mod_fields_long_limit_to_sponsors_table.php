<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModFieldsLongLimitToSponsorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sponsors', function (Blueprint $table) {
            $table->text('name')->change();
            $table->text('en_name')->change();
            $table->text('introduction')->change();
            $table->text('en_introduction')->change();
            $table->text('website')->change();
            $table->text('social_media')->change();
            $table->text('production')->change();
            $table->text('logo_path')->change();
            $table->text('service_photo_path')->change();
            $table->text('promote')->change();
            $table->text('slide_path')->change();
            $table->text('board_path')->change();
            $table->text('opening_remarks')->change();
            $table->text('recipe_full_name')->change();
            $table->text('recipe_tax_id_number')->change();
            $table->text('recipe_contact_name')->change();
            $table->text('recipe_contact_title')->change();
            $table->text('recipe_contact_phone')->change();
            $table->text('recipe_contact_email')->change();
            $table->text('recipe_contact_address')->change();
            $table->text('reason')->change();
            $table->text('purpose')->change();
            $table->text('remark')->change();
            $table->text('advence_icck_ad_path')->change();
            $table->text('advence_registration_ad_path')->change();
            $table->text('advence_keynote')->change();
            $table->text('advence_hall_flag_path')->change();
            $table->text('advence_main_flow_flag_path')->change();
            $table->text('note')->change();
        });
    }
}
