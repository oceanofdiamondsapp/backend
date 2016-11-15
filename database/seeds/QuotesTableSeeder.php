<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use OOD\JewelryType;
use OOD\Status;
use OOD\Quotes\Quote;
use OOD\Users\User;
use OOD\Jobs\Job;
use OOD\Tax;

class QuotesTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('quotes')->delete();
		
		// Get the admin user writing the quotes
		$user = User::find(1);

		// Create quote object
		$quote = new Quote([
			'quote_number' => 'Q' . date('y') . '00001A',
			'description' => 'Etiam porta urna eu erat dictum, a scelerisque quam dictum. Nullam id nisi posuere, vulputate tellus id, aliquam nisl.',
			'stones_description' => 'Nullam id nisi posuere, vulputate tellus id, aliquam nisl.',
			'metals_description' => 'This is the metals description field.',
			'setting_details' => 'The setting is described here in detail.',
			'size_details' => 'The size details can be included here.',
			'other_details' => 'Additional details can be included here.',
			'price' => 259.50,
			'shipping' => 10,
			'expires_at' => date('Y-m-d H:i:s', strtotime('+30 days')),
			'updated_at' => date('Y-m-d H:i:s', strtotime('+5 days')),
		]);

		// Set foreign keys / relationships
		$quote->job()->associate(Job::find(1));
		$quote->tax()->associate(Tax::find(1));
		$quote->status()->associate(Status::find(6)); // Submitted
		$quote->jewelryType()->associate(JewelryType::find(1));

		// Save as user 1
		$user->quotes()->save($quote);

		// Update job 1 status to 'quoted'
		$job = Job::find(1);
		$job->status()->associate(Status::find(3)); // Quoted
		$job->save();
	}

}
