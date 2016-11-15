<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use OOD\Jobs\Job;

class JobsStonesTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('jobs_stones')->delete();

		$job = Job::find(1);
		$job->stones()->attach([1, 2]);

		$job = Job::find(2);
		$job->stones()->attach(3);

		$job = Job::find(4);
		$job->stones()->attach([2, 4]);
	}

}
