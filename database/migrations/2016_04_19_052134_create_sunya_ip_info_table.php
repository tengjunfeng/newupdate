<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSunyaIpInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sunya_ip_info', function (Blueprint $table) {
        $table->increments('id');
	    $table->string('country');
		$table->string('province');
		$table->string('city');
	    $table->string('dev_ip');
		$table->string('sn');
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
        Schema::drop('sunya_ip_info');
    }
}
