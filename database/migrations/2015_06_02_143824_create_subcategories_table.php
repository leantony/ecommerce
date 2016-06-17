<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSubcategoriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('subcategories', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name', 50)->unique('name');
			$table->integer('category_id')->unsigned()->index('FK_sub_categories_categories');
			$table->string('alias', 50)->nullable();
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
		Schema::drop('subcategories');
	}

}
