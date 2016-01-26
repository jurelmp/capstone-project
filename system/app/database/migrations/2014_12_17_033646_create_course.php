<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCourse extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('course', function(Blueprint $table){
			$table->increments('id');
			$table->string('title');
			$table->text('description');
			$table->char('code', 10)->nullable();
			$table->integer('dept_id')->unsigned();
			$table->foreign('dept_id')->references('id')->on('departments');
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
		Schema::drop('course');
	}

}
