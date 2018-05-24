<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
        $table->increments('id');
	    $table->string('name');
		$table->integer('code');
		$table->integer('num_all');
	    $table->integer('num_week');
		$table->integer('num_month');
		$table->integer('num_year');
		$table->string('user');
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
        Schema::drop('companies');
    }
}
