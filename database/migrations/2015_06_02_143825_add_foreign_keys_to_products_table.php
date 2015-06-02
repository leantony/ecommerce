<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToProductsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('products', function(Blueprint $table)
		{
			$table->foreign('brand_id', 'FK_products_brands')->references('id')->on('brands')->onUpdate('CASCADE')->onDelete('RESTRICT');
			$table->foreign('category_id', 'FK_products_categories')->references('id')->on('categories')->onUpdate('CASCADE')->onDelete('RESTRICT');
			$table->foreign('subcategory_id', 'FK_products_sub_categories')->references('id')->on('subcategories')->onUpdate('CASCADE')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('products', function(Blueprint $table)
		{
			$table->dropForeign('FK_products_brands');
			$table->dropForeign('FK_products_categories');
			$table->dropForeign('FK_products_sub_categories');
		});
	}

}
