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
			$table->char('uuid', 36);
			$table->string('first_name', 191)->nullable();
			$table->string('last_name', 191)->nullable();
			$table->string('email', 191)->unique();
			$table->string('avatar_type', 191)->default('gravatar');
			$table->string('avatar_location', 191)->nullable();
			$table->string('password', 191)->nullable();
			$table->dateTime('password_changed_at')->nullable();
			$table->boolean('active')->default(1);
			$table->string('confirmation_code', 191)->nullable();
			$table->boolean('confirmed')->default(1);
			$table->string('timezone', 191)->default('UTC');
			$table->string('remember_token', 100)->nullable();
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
