<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TablaDetalleCasa extends Migration
{
	public function up()
	{
		Schema::create('DetalleCasa', function (Blueprint $table)
		{
			$table->id();

			// LLave foranea id_casa = Casa(id)
			$table->foreignId('id_casa')->constrained('Casa');

			// LLave foranea id_dueño = Dueño(id)
			$table->foreignId('id_dueño')->nullable()->constrained('Dueño');

			// LLave foranea id_invitado = Invitado(id)
			$table->foreignId('id_invitado')->nullable()->constrained('Invitado');
		});
	}

	public function down()
	{
		Schema::dropIfExists('DetalleCasa');
	}
};