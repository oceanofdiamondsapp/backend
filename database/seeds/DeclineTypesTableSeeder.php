<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use OOD\Quotes\DeclineType;

class DeclineTypesTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('decline_types')->delete();

		DeclineType::create(['description' => 'NO LONGER INTERESTED']);
		DeclineType::create(['description' => 'TOO EXPENSIVE']);
		DeclineType::create(['description' => 'BOUGHT ELSEWHERE']);
		DeclineType::create(['description' => 'I WAS JUST CURIOUS']);
		DeclineType::create(['description' => 'OTHER']);
	}

}
