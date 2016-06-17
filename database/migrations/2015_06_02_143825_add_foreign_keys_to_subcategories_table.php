<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToSubcategoriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('subcategories', function(Blueprint $table)
		{
			$table->foreign('category_id', 'FK_sub_categories_categories')->references('id')->on('categories')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('subcategories', function(Blueprint $table)
		{
			$table->dropForeign('FK_sub_categories_categories');
		});
	}

}
