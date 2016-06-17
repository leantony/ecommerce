<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGuestOrderTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('guest_order', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('order_id', 100)->index('guest_order_ibfk_1');
			$table->integer('guest_id')->unsigned()->index('guest_order_ibfk_2');
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('guest_order');
	}

}
