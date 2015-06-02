<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToCartProductTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('cart_product', function(Blueprint $table)
		{
			$table->foreign('cart_id', 'FK_cart_contains_many_products')->references('id')->on('carts')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('product_id', 'FK_cart_product_products')->references('id')->on('products')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('cart_product', function(Blueprint $table)
		{
			$table->dropForeign('FK_cart_contains_many_products');
			$table->dropForeign('FK_cart_product_products');
		});
	}

}
