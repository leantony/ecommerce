<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCartProductTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cart_product', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('cart_id', 100)->index('FK_cart_contains_many_products');
			$table->integer('product_id')->unsigned()->index('FK_cart_product_products');
			$table->integer('quantity')->unsigned()->default(1);
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
		Schema::drop('cart_product');
	}

}
