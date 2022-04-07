<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TablaSensor extends Migration
{
	public function up()
	{
		Schema::create('Sensor', function (Blueprint $table)
		{
			$table->id();
			$table->string('nombre')->default('Sensor');
		});
	}

	public function down()
	{
		Schema::dropIfExists('Sensor');
	}
};