<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUpgradeFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('upgrade_files', function (Blueprint $table) {
        $table->increments('id');
	    $table->string('name');
	    $table->integer('code');
		$table->integer('language');
	    $table->string('file_md5');
		$table->integer('size');
		$table->integer('start_version');
		$table->integer('end_version');
		$table->string('user');
		$table->string('description');
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
         Schema::drop('upgrade_files');
    }
}
