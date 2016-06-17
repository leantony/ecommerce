<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('products', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('brand_id')->unsigned()->nullable()->default(0)->index('FK_products_brands');
			$table->integer('category_id')->unsigned()->nullable()->default(0)->index('FK_products_categories');
			$table->integer('subcategory_id')->unsigned()->nullable()->default(0)->index('FK_products_sub_categories');
			$table->string('sku', 50)->unique('sku');
			$table->string('name');
			$table->integer('price')->unsigned();
			$table->integer('shipping')->unsigned()->nullable()->default(0);
			$table->float('discount', 10, 0)->unsigned()->nullable();
			$table->integer('quantity')->unsigned();
			$table->integer('available')->default(1);
			$table->text('description_short', 65535)->nullable();
			$table->text('description_long', 65535);
			$table->text('stuff_included', 65535)->nullable();
			$table->float('warranty_period', 10, 0)->unsigned()->nullable();
			$table->binary('image', 65535);
			$table->binary('image_large', 16777215)->nullable();
			$table->boolean('zoomable')->default(1);
			$table->integer('free')->unsigned()->default(0);
			$table->integer('taxable')->unsigned()->default(1);
			$table->timestamps();
			$table->softDeletes();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('products');
	}

}
