<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('first_name', 50);
			$table->string('last_name', 50);
			$table->bigInteger('phone');
			$table->integer('county_id')->unsigned()->nullable()->index('FK_users_counties');
			$table->string('town', 50);
			$table->string('home_address', 50);
			$table->binary('avatar', 16777215)->nullable();
			$table->string('email', 100)->unique('email_address');
			$table->date('dob')->nullable();
			$table->enum('gender', array('Female','Male'))->nullable();
			$table->string('password', 100);
			$table->boolean('confirmed')->default(0);
			$table->string('remember_token')->nullable();
			$table->string('confirmation_code')->nullable();
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
		Schema::drop('users');
	}

}
