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
			'description' => 'NJ 6.875%',
			'amount' => 0.06875
		]);

		Tax::create([
			'description' => 'Rest of U.S. 0%',
			'amount' => 0
		]);
	}

}
