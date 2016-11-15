<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use OOD\Status;

class StatusesTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('statuses')->delete();

		Status::create(['description' => 'REQUEST']);
		Status::create(['description' => 'SAVED']);
		Status::create(['description' => 'QUOTED']);
		Status::create(['description' => 'LAPSED']);
		Status::create(['description' => 'DECLINED']);
		Status::create(['description' => 'SUBMITTED']);
		Status::create(['description' => 'ORDERED']);
		Status::create(['description' => 'IN PROGRESS']);
		Status::create(['description' => 'SHIPPED']);
		Status::create(['description' => 'COMPLETED']);
	}

}
