<?php

$factory('OOD\Message', [
	'body' => $faker->sentence
]);

$factory('OOD\Users\User', [
	'name' => $faker->name,
	'email' => $faker->email,
	'password' => Hash::make('password'),
	'created_at' => $faker->dateTime()
]);

$factory('OOD\Users\Account', [
	'name' => $faker->name,
	'email' => $faker->email,
	'password' => Hash::make('password'),
	'created_at' => $faker->dateTime()
]);

$factory('OOD\Jobs\Job', [
	'nickname' => $faker->words(4),
	'carat' => $faker->randomFloat(2, 0, 10),
	'budget' => $faker->randomNumber(4),
	'deadline' => date('Y-m-d H:i:s', strtotime('+30 days')),
	'ship_to_state' => $faker->stateAbbr,
	'notes' => $faker->sentence,
	'has_unread_messages' => 0,
	'account_id' => 'factory:OOD\Users\Account'
]);
