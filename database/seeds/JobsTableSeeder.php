<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use OOD\Users\Account;
use OOD\Jobs\Job;

class JobsTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('jobs')->delete();

		// John Smith's requests
		$jobs = [
			new Job([
				'nickname' => 'Graduation Ring',
				'carat' => 0.25,
				'budget' => 2500,
				'deadline' => date('Y-m-d H:i:s', strtotime('+30 days')),
				'ship_to_state' => 'PA',
				'notes' => 'This is a ring for my little sister.'
			]),
			new Job([
				'nickname' => 'Gold Ring #1',
				'carat' => 0.5,
				'budget' => 1500,
				'deadline' => date('Y-m-d H:i:s', strtotime('+30 days')),
				'ship_to_state' => 'PA',
				'notes' => 'Just testin out the app man'
			]),
			new Job([
				'nickname' => 'Emerald and Silver Ring',
				'carat' => 0.0,
				'budget' => 750,
				'deadline' => date('Y-m-d H:i:s', strtotime('+30 days')),
				'ship_to_state' => 'PA',
				'notes' => 'I would like the emerald to be of high quality please.'
			])
		];

		$account = Account::find(2);
		$account->jobs()->saveMany($jobs);

		// Jane Doe's jobs
		$jobs = [
			new Job([
				'nickname' => 'Simple Diamon Ring',
				'carat' => 0.1,
				'budget' => 500,
				'deadline' => date('Y-m-d H:i:s', strtotime('+30 days')),
				'ship_to_state' => 'NJ',
				'notes' => 'Mauris ut malesuada massa. Sed quis magna dui. Pellentesque volutpat, nibh at varius blandit, enim urna accumsan mauris, vitae pretium sapien mauris eu metus. Vivamus et metus vel risus varius iaculis. Aliquam nisl nulla, interdum facilisis turpis non, facilisis dignissim dolor. Proin quis rhoncus tellus. Aenean facilisis diam at odio maximus porta. Quisque sit amet luctus erat.'
			])
		];

		$account = Account::find(3);
		$account->jobs()->saveMany($jobs);
	}

}
