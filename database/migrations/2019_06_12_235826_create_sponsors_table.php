<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSponsorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sponsors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('sponsor_type')->nullable()->comment        = '贊助商類型(sponsor_type.id)';
            $table->tinyInteger('sponsor_status')->nullable()->comment          = '0:待確認,1:確認中,2:已確認,3:下架';
            $table->string('name')->nullable()->comment                         = '公司名稱';
            $table->string('en_name')->nullable()->comment                      = '公司英文名稱';
            $table->string('introduction')->nullable()->comment                 = '公司簡介';
            $table->string('en_introduction')->nullable()->comment              = '公司英文簡介';
            $table->string('website')->nullable()->comment                      = '公司網站';
            $table->string('social_media')->nullable()->comment                 = '社群媒體(如FB等)';
            $table->string('production')->nullable()->comment                   = '產品及服務介紹';
            $table->string('logo_path')->nullable()->comment                    = 'logo(path)';
            $table->string('service_photo_path')->nullable()->comment           = '產品或服務照片(path)';
            $table->string('promote')->nullable()->comment                      = '希望MOPCON宣傳的內容(FB)';
            $table->string('slide_path')->nullable()->comment                   = '場間投影片(path)';
            $table->string('board_path')->nullable()->comment                   = '電子看板(path)';
            $table->string('opening_remarks')->nullable()->comment              = '晚宴簡介';
            $table->string('recipe_full_name')->nullable()->comment             = '公司/組織全銜';
            $table->string('recipe_tax_id_number')->nullable()->comment         = '統一編號';
            $table->unsignedInteger('recipe_amount')->nullable()->comment       = '贊助金額';
            $table->string('recipe_contact_name')->nullable()->comment          = '聯絡人姓名';
            $table->string('recipe_contact_title')->nullable()->comment         = '聯絡人職稱';
            $table->string('recipe_contact_phone')->nullable()->comment         = '聯絡人電話';
            $table->string('recipe_contact_email')->nullable()->comment         = '聯絡人Email';
            $table->string('recipe_contact_address')->nullable()->comment       = '收件地址';
            $table->string('reason')->nullable()->comment                       = '為什麼本次選擇贊助 MOPCON？';
            $table->string('purpose')->nullable()->comment                      = '希望能在本次大會達成的目標';
            $table->string('remark')->nullable()->comment                       = '備註';
            $table->string('advence_icck_ad_path')->nullable()->comment         = 'ICCK大門兩側廣告(path)';
            $table->string('advence_registration_ad_path')->nullable()->comment = '報到處全版廣告空間(path)';
            $table->string('advence_keynote')->nullable()->comment              = 'Keynote 引言';
            $table->string('advence_hall_flag_path')->nullable()->comment       = '演講廳旗幟(path)';
            $table->string('advence_main_flow_flag_path')->nullable()->comment  = '主動線旗幟廣告(path)';
            $table->uuid('access_key')->index()->comment                        = '認證token';
            $table->string('access_secret', 20)->comment                        = '認證secret';
            $table->unsignedInteger('updated_by')->nullable()->comment          = '最後更新者';
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
        Schema::dropIfExists('sponsors');
    }
}
