<?php namespace App\Events\Jobs;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;

class LoggableEventOccurred extends Event {

	use SerializesModels;

	/**
	 * @var string
	 */
	public $description;

	/**
	 * @var OOD\Users\User
	 */
	public $user;

	/**
	 * @var OOD\Jobs\Job
	 */
	public $job;

	/**
	 * Create a new loggable event instance.
	 *
	 * @return void
	 */
	public function __construct($description, $user, $job)
	{
		$this->description = $description;
		$this->user = $user;
		$this->job = $job;
	}

}
