<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('orders', function(Blueprint $table)
		{
			$table->string('pp_transaction_id')->primary();
			$table->char('order_number', 9);
			$table->integer('quote_id')->unsigned();
			$table->string('pp_payer_name');
			$table->string('pp_payer_email');
			$table->string('pp_payer_status');
			$table->string('pp_payer_id');
			$table->string('pp_ship_to_addr_name');
			$table->string('pp_ship_to_addr_line1');
			$table->string('pp_ship_to_addr_line2')->nullable();
			$table->string('pp_ship_to_addr_city');
			$table->char('pp_ship_to_addr_state', 2);
			$table->char('pp_ship_to_addr_zip', 5);
			$table->string('pp_ship_to_addr_status');
			$table->decimal('pp_gross_amount', 9, 2);
			$table->decimal('pp_tax_amount', 9, 2);
			$table->decimal('pp_fee_amount', 9, 2);
			$table->string('pp_token');
			$table->integer('status_id')->unsigned()->default(7);
			$table->boolean('has_unread_messages')->default(0);
			$table->timestamps();

			$table->foreign('quote_id')->references('id')->on('quotes');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('orders');
	}

}
