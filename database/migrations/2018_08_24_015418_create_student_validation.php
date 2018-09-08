<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentValidation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_validation', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedSmallInteger('verify_year')->comment = "儲存驗證年份";
            $table->unsignedTinyInteger('is_verify')->default(false)->comment = '是否已經通過驗證了';
            $table->unsignedInteger('verify_user_id');
            $table->unsignedInteger('order_id');
            $table->unsignedInteger('register_no');
            $table->string('purchase_date')->comment = "購票日期";
            $table->string('name');
            $table->string('email');
            $table->text('school_name')->nullable();
            $table->text('file_link')->nullable();
            $table->text('comment')->nullable();
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
        Schema::dropIfExists('student_validation');
    }
}
