<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TablaDetalleSensor extends Migration
{
	public function up()
	{
		Schema::create('DetalleSensor', function (Blueprint $table)
		{
			$table->id();

			// LLave foranea id_sensor = Sensor(id)
			$table->foreignId('id_sensor')->constrained('Sensor');

			// LLave foranea id_detalle_habitacion = DetalleHabitacion(id)
			$table->foreignId('id_detalle_habitacion')->constrained('DetalleHabitacion');
		});
	}

	public function down()
	{
		Schema::dropIfExists('DetalleSensor');
	}
};