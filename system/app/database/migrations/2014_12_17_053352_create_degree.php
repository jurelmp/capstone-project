<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDegree extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('degree', function(Blueprint $table){
			$table->increments('id');
			$table->string('program');
			$table->string('title');
			$table->char('year_graduated', 4);
			$table->string('school_attended');
			$table->integer('alumni_id')->unsigned();
			$table->foreign('alumni_id')->references('id')->on('alumni');
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
		Schema::drop('degree');
	}

}
