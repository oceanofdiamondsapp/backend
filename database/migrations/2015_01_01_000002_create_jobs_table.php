<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('jobs', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('nickname', 50);
			$table->decimal('carat', 4, 2);
			$table->integer('budget')->unsigned();
			$table->dateTime('deadline');
			$table->char('ship_to_state', 2);
			$table->text('notes');
			$table->boolean('has_unread_messages')->default(0);
			$table->integer('account_id')->unsigned();
			$table->boolean('is_active')->default(0);
			$table->integer('status_id')->unsigned()->default(1);
			$table->timestamps();

			$table->foreign('account_id')->references('id')->on('users');
			$table->foreign('status_id')->references('id')->on('statuses');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('jobs');
	}

}
