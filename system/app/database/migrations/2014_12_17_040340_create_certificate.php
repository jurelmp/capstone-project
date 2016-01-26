<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCertificate extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('certificate', function(Blueprint $table){
			$table->increments('id');
			$table->string('title');
			$table->string('description')->nullable();
			$table->string('file_path')->nullable();
			$table->char('year_taken', 4);
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
		Schema::drop('certificate');
	}

}
