<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlumni extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('alumni', function(Blueprint $table){
			$table->increments('id');
			$table->string('lastname');
			$table->string('firstname');
			$table->string('midname');
			$table->integer('gender');
			$table->integer('civil_stat');
			$table->date('birthdate');
			$table->string('address')->nullable();
			$table->string('email')->nullable();
			$table->char('tel_no', 15)->nullable();
			$table->char('mobile_no', 15)->nullable();
			$table->string('pic_path')->nullable();
			$table->integer('region_id')->unsigned();
			$table->foreign('region_id')->references('id')->on('regions');
			$table->integer('province_id')->unsigned();
			$table->foreign('province_id')->references('id')->on('provinces');
			$table->boolean('is_id_released')->default(0);
			$table->boolean('is_confirmed')->default(0);
			$table->integer('course_id')->unsigned();
			$table->foreign('course_id')->references('id')->on('course');
			$table->char('year_graduated', 4);
			$table->integer('account_id')->unsigned()->nullable();
			$table->foreign('account_id')->references('id')->on('accounts');
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
		Schema::drop('alumni');
	}

}
