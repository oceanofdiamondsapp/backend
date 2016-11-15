<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuotesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('quotes', function(Blueprint $table)
		{
			$table->increments('id');
			$table->char('quote_number', 9);
			$table->text('description');
			$table->text('stones_description');
			$table->text('metals_description');
			$table->text('setting_details')->nullable();
			$table->text('size_details')->nullable();
			$table->text('other_details')->nullable();
			$table->decimal('price', 9, 2);
			$table->decimal('shipping', 9, 2)->default(0);
			$table->integer('tax_id')->unsigned();
			$table->dateTime('expires_at');
			$table->integer('user_id')->unsigned();
			$table->integer('status_id')->unsigned();
			$table->integer('job_id')->unsigned();
			$table->integer('jewelry_type_id')->unsigned();
			$table->timestamps();

			$table->foreign('tax_id')->references('id')->on('taxes');
			$table->foreign('status_id')->references('id')->on('statuses');
			$table->foreign('user_id')->references('id')->on('users');
			$table->foreign('job_id')->references('id')->on('jobs');
			$table->foreign('jewelry_type_id')->references('id')->on('jewelry_types');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('quotes');
	}

}
