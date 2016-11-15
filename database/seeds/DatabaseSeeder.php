<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();

		// "Lookup" tables
		$this->call('DeclineTypesTableSeeder');
		$this->call('JewelryTypesTableSeeder');
		$this->call('StatusesTableSeeder');
		$this->call('RolesTableSeeder');
		$this->call('MetalsTableSeeder');
		$this->call('StonesTableSeeder');
		$this->call('TaxesTableSeeder');

		// Test data
		$this->call('UsersTableSeeder');
		$this->call('UsersRolesTableSeeder');
		// $this->call('JobsTableSeeder');
		// $this->call('JobsMetalsTableSeeder');
		// $this->call('JobsStonesTableSeeder');
		// $this->call('QuotesTableSeeder');
		// $this->call('NotesTableSeeder');
	}

}
