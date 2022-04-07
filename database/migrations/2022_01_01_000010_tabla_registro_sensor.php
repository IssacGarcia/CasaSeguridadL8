<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TablaRegistroSensor extends Migration
{
	public function up()
	{
		Schema::create('RegistroSensor', function (Blueprint $table)
		{
			$table->id();
			$table->string('valor');
			$table->dateTime('fecha');

			// LLave foranea id_detalle_sensor = DetalleSensor(id)
			$table->foreignId('id_detalle_sensor')->constrained('DetalleSensor');
		});
	}

	public function down()
	{
		Schema::dropIfExists('RegistroSensor');
	}
};