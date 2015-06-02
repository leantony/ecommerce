<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToGuestOrderTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('guest_order', function(Blueprint $table)
		{
			$table->foreign('order_id', 'guest_order_ibfk_1')->references('id')->on('orders')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('guest_id', 'guest_order_ibfk_2')->references('id')->on('guests')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('guest_order', function(Blueprint $table)
		{
			$table->dropForeign('guest_order_ibfk_1');
			$table->dropForeign('guest_order_ibfk_2');
		});
	}

}
