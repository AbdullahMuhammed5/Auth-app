<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class SetupCountriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return  void
	 */
	public function up()
	{
		// Creates the users table
		Schema::create(\Config::get('countries.table_name'), function($table)
		{
            $table->unsignedInteger('id')->index();
            $table->string('name', 255);
            $table->string('full_name', 255)->nullable();
            $table->string('capital', 255)->nullable();
            $table->primary('id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return  void
	 */
	public function down()
	{
		Schema::drop(\Config::get('countries.table_name'));
	}

}
