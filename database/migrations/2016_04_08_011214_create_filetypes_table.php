<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFiletypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('filetypes', function (Blueprint $table) {
        $table->increments('id');
	    $table->string('type');
	    $table->integer('code');
		$table->integer('status');
		$table->string('postfix');
	    $table->string('user');
		$table->string('folder');
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
        Schema::drop('filetypes');
    }
}
