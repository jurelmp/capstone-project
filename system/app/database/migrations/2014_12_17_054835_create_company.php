<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompany extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('company', function(Blueprint $table){
			$table->increments('id');
			$table->string('name');
			$table->string('email')->nullable();
			$table->text('description')->nullable();
			$table->char('tel_no', 15)->nullable();
			$table->char('mobile_no', 15)->nullable();
			$table->integer('field_id')->unsigned();
			$table->foreign('field_id')->references('id')->on('fields');
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
		Schema::drop('company');
	}

}
