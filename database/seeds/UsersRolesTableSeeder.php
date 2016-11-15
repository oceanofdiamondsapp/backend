<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use OOD\Users\User;

class UsersRolesTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('users_roles')->delete();

		User::find(1)->roles()->attach(1);
		User::find(2)->roles()->attach(1);
//		User::find(3)->roles()->attach(2);
//		User::find(4)->roles()->attach(2);
	}

}
