<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAnonymousMessagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('anonymous_messages', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('message', 500);
			$table->string('subject', 100)->nullable();
			$table->string('user_name', 50)->nullable();
			$table->string('email', 50);
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
		Schema::drop('anonymous_messages');
	}

}
