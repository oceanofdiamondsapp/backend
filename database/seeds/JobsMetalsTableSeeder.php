<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use OOD\Jobs\Job;

class JobsMetalsTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('jobs_metals')->delete();

		$job = Job::find(1);
		$job->metals()->attach(1);

		$job = Job::find(2);
		$job->metals()->attach(3);

		$job = Job::find(4);
		$job->metals()->attach(2);
	}

}
