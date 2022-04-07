<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TablaHabitacion extends Migration
{
	public function up()
	{
		Schema::create('Habitacion', function (Blueprint $table)
		{
			$table->id();
			$table->string('nombre')->default('Habitacion');
		});
	}

	public function down()
	{
		Schema::dropIfExists('Habitacion');
	}
};