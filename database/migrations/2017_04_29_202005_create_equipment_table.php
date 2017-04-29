<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEquipmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('source')->default('');
            $table->string('memo')->default('');
            $table->unsignedInteger('amount');
            $table->unsignedInteger('loan')->default(0);
            $table->tinyInteger('hasBarcode');
            $table->string('prefix')->default('');
        });

        Schema::create('equipment_barcodes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('barcode');
            $table->unsignedInteger('equipment_id');
            $table->tinyInteger('status')->default(0)->comment = "0: 未出借, 1:出借中";;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('equipments');
        Schema::dropIfExists('equipment_barcodes');
    }
}
