<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrderUserTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('order_user', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('order_id', 100)->index('order_user_ibfk_1');
			$table->integer('user_id')->unsigned()->index('order_user_ibfk_2');
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
		Schema::drop('order_user');
	}

}
