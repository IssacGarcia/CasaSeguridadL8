<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TablaUsuario extends Migration
{
	public function up()
	{
		Schema::create('Usuario', function (Blueprint $table)
		{
			$table->id();
			$table->string('email')->required()->unique();
			$table->string('password')->required();
			$table->string('nombre')->default('');
			$table->string('apellidos')->default('');
			$table->string('telefono')->default('');
		});
	}

	public function down()
	{
		Schema::dropIfExists('Usuario');
	}
}