<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkExperience extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('work_experience', function(Blueprint $table){
			$table->increments('id');
			$table->integer('alumni_id')->unsigned();
			$table->foreign('alumni_id')->references('id')->on('alumni');
			$table->integer('company_id')->unsigned();
			$table->foreign('company_id')->references('id')->on('company');
			$table->integer('occupation_id')->unsigned();
			$table->foreign('occupation_id')->references('id')->on('occupation');
			$table->date('date_hired')->nullable();
			$table->date('date_finished')->nullable();
			$table->integer('place_of_work');
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
		Schema::drop('work_experience');
	}

}
