<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use OOD\Users\User;

class UsersTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('users')->delete();

		User::create([
			'name' => 'Hasmik Mardo',
			'email' => 'jazzysocean@gmail.com',
			'password' => Hash::make('D!amond5App'),
			'phone_number' => '00000000'
		]);

		User::create([
			'name' => 'Sahil Mardo',
			'email' => 'Salsocean@gmail.com',
			'password' => Hash::make('D!amond5App'),
			'phone_number' => '11111111'
		]);

		User::create([
			'name' => 'Phil Smith',
			'email' => 'phil.smith@themixxnyc.com',
			'password' => Hash::make('D!amond5App'),
			'phone_number' => '22222222'
		]);
	}

}
