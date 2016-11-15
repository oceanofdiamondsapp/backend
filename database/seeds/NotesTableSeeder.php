<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use OOD\Note;
use OOD\Users\Account;
use OOD\Users\User;
use OOD\Quotes\Quote;

class NotesTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('notes')->delete();

		$user = User::find(1); // The user writing the notes

		$account = Account::find(3);
		$note = new Note(['body' => 'Jane Doe is a very good customer. Give her prompt service.']);
		$note->user()->associate($user);
		$account->notes()->save($note);
		
		$quote = Quote::find(1);
		$note = new Note(['body' => 'This is a quote note. It appears only on the quote. The client doesn\'t see this.']);
		$note->user()->associate($user);
		$quote->notes()->save($note);
	}

}
