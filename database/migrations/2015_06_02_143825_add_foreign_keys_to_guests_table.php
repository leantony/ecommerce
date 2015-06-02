<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToGuestsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('guests', function(Blueprint $table)
		{
			$table->foreign('county_id', 'guest_belongs_to_county')->references('id')->on('counties')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('guests', function(Blueprint $table)
		{
			$table->dropForeign('guest_belongs_to_county');
		});
	}

}
