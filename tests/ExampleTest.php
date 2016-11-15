<?php

use Laracasts\TestDummy\Factory as TestDummy;

class ExampleTest extends TestCase {

	/** @test */
	// public function it_creates_jobs()
	// {
	// 	$jobs = TestDummy::times(2)->create('OOD\Jobs\Job');

	// 	foreach ($jobs as $job)
	// 	{
	// 		$job->metals()->attach([rand(1, 5), rand(1, 5)]);
	// 		$job->stones()->attach([rand(1, 4)]);
	// 	}

	// 	$this->verifyInDatabase('jobs', ['nickname' => $jobs->first()->nickname]);
	// }

	/** @test */
	// public function it_loads_the_login_page()
	// {
	// 	$this->visit('/auth/login')
	// 		 ->andSee('Login');
	// }

	/** @test */
	// public function it_creates_a_user()
	// {
	// 	$user = TestDummy::create('OOD\Users\User');

	// 	$user->roles()->attach(2);

	// 	$this->verifyInDatabase('users', $user->toArray());
	// }

	/** @test */
	// public function it_creates_users()
	// {
	// 	$users = TestDummy::times(500)->create('OOD\Users\User');

	// 	foreach ($users as $user)
	// 	{
	// 		$user->roles()->attach(2);
	// 	}

	// 	$this->verifyInDatabase('users', $users->first()->toArray());
	// }

	/** @test */
	// public function it_creates_a_job_for_a_new_user()
	// {
	// 	$job = TestDummy::build('OOD\Jobs\Job');

	// 	$account = TestDummy::create('OOD\Users\Account');
	// 	$account->jobs()->save($job);
	// 	$account->roles()->attach(2);

	// 	$job->metals()->attach([rand(1, 5), rand(1, 5)]);
	// 	$job->stones()->attach([rand(1, 4)]);

	// 	$this->verifyInDatabase('jobs', ['nickname' => $job->nickname]);
	// }

}
