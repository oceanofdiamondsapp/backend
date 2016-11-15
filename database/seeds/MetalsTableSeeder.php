<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use OOD\Jobs\Metal;

class MetalsTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('metals')->delete();

		Metal::create(['description' => 'SILVER']);
		Metal::create(['description' => 'YELLOW GOLD']);
		Metal::create(['description' => 'ROSE GOLD']);
		Metal::create(['description' => 'WHITE GOLD']);
		Metal::create(['description' => 'PLATINUM']);
	}

}
