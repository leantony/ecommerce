<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

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
			$table->string('id', 100)->primary();
			$table->text('data', 65535);
			$table->timestamps();
			$table->softDeletes()->default('0000-00-00 00:00:00');
			$table->integer('delivered')->unsigned()->default(0);
			$table->dateTime('delivered_at')->nullable()->default('0000-00-00 00:00:00');
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
