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
			'name' => 'Oscar',
			'email' => 'oscar.bengtsson412@gmail.com',
			'password' => Hash::make('12345678'),
			'phone_number' => '00000000'
		]);

		User::create([
			'name' => 'Phil Smith',
			'email' => 'phil.smith@themixxnyc.com',
			'password' => Hash::make('12345678'),
			'phone_number' => '11111111'
		]);

//		User::create([
//			'name' => 'Chris Löfgren',
//			'email' => 'chriseen313@gmail.com',
//			'password' => Hash::make('password'),
//			'phone_number' => '23421341'
//		]);
//		User::create([
//			'name' => 'Leo Myth',
//			'email' => 'leomyth330@gmail.com',
//			'password' => Hash::make('12345678'),
//			'phone_number' => '23435239'
//		]);
	}

}
