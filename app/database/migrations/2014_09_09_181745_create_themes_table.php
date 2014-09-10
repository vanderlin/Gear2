<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateThemesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('themes', function(Blueprint $table) {
			$table->increments('id');
			$table->string('path');
			$table->string('name');
			$table->boolean('active')->default(0);
			$table->text('code');
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('themes');
	}

}
