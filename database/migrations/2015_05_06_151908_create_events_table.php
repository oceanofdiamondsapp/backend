<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('events', function(Blueprint $table)
		{
			$table->increments('id');
			$table->text('description');
			$table->integer('user_id')->unsigned();
			$table->integer('job_id')->unsigned();
			$table->timestamps();

			$table->foreign('user_id')->references('id')->on('users');
			$table->foreign('job_id')->references('id')->on('jobs');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('events');
	}

}
