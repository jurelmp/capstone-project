<?php

class Regions extends Seeder{

	public function run(){

		DB::table('regions')->delete();

		$regions = array(
			array(
				'name' => 'NCR'
			),
			array(
				'name' => 'CAR'
			),
			array(
				'name' => 'Region I'
			),
			array(
				'name' => 'Region II'
			),
			array(
				'name' => 'Region III'
			),
			array(
				'name' => 'Region IV-A'
			),
			array(
				'name' => 'Region IV-B'
			),
			array(
				'name' => 'Region V'
			),
			array(
				'name' => 'Region VI'
			),
			array(
				'name' => 'Region VII'
			),
			array(
				'name' => 'Region VIII'
			),
			array(
				'name' => 'Region IX'
			),
			array(
				'name' => 'Region X'
			),
			array(
				'name' => 'Region XI'
			),
			array(
				'name' => 'Region XII'
			),
			array(
				'name' => 'Region XIII'
			),
			array(
				'name' => 'ARMM'
			)
		);

		DB::table('regions')->insert($regions);
	}
}