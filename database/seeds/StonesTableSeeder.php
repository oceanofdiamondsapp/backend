<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use OOD\Jobs\Stone;

class StonesTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('stones')->delete();

		Stone::create(['description' => 'DIAMOND']);
		Stone::create(['description' => 'RUBY']);
		Stone::create(['description' => 'SAPPHIRE']);
		Stone::create(['description' => 'EMERALD']);
	}

}
