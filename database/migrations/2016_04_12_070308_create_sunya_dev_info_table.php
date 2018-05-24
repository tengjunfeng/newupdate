<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSunyaDevInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sunya_dev_info', function (Blueprint $table) {
        $table->increments('id');
	    $table->integer('T_REQ_TYPE_ID');
		$table->integer('T_REQ_PACK_ID');
	    $table->string('T_DEVICE_IP');
		$table->string('T_DEVICE_SN');
		$table->integer('oem_code');
		$table->string('oem_name');
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
        Schema::drop('sunya_dev_info');
    }
}
