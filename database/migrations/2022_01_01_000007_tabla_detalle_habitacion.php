<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TablaDetalleHabitacion extends Migration
{
	public function up()
	{
		Schema::create('DetalleHabitacion', function (Blueprint $table)
		{
			$table->id();

			// LLave foranea id_habitacion = Habitacion(id)
			$table->foreignId('id_habitacion')->constrained('Habitacion');

			// LLave foranea id_detalle_casa = DetalleCasa(id)
			$table->foreignId('id_detalle_casa')->constrained('DetalleCasa');
		});
	}

	public function down()
	{
		Schema::dropIfExists('DetalleHabitacion');
	}
};