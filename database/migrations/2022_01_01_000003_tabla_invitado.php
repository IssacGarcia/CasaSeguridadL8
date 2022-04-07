<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TablaInvitado extends Migration
{
	public function up()
	{
		Schema::create('Invitado', function (Blueprint $table)
		{
			$table->id();
			$table->string('alias');

			// LLave foranea id_usuario = Usuario(id)
			$table->foreignId('id_usuario')->constrained('Usuario');
		});
	}

	public function down()
	{
		Schema::dropIfExists('Invitado');
	}
};