<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use OOD\Tax;

class TaxesTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('taxes')->delete();

		Tax::create([
			'description' => 'NJ 7%',
			'amount' => 0.07
		]);

		Tax::create([
			'description' => 'Rest of U.S. 0%',
			'amount' => 0
		]);
	}

}
