<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToReviewsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('reviews', function(Blueprint $table)
		{
			$table->foreign('product_id', 'product_has_many_reviews')->references('id')->on('products')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('user_id', 'user_can_make_many_reviews')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('reviews', function(Blueprint $table)
		{
			$table->dropForeign('product_has_many_reviews');
			$table->dropForeign('user_can_make_many_reviews');
		});
	}

}
