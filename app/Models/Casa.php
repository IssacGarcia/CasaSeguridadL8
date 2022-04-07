<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Casa extends Model
{
	use HasFactory;
	public $timestamps = false;
	protected $table = 'Casa';

	protected $fillable =
	[
		'nombre',
		'direccion'
	];

	public function detalles_casa()
	{
		return $this->hasMany(DetalleCasa::class, 'id_casa');
	}

	public function invitados()
	{
		$detalles_casa = $this->detalles_casa();
		return $detalles_casa
			->join('Invitado', 'Invitado.id', '=', 'DetalleCasa.id_invitado')
			->join('Usuario', 'Usuario.id', '=', 'Invitado.id_usuario')
			->select('Usuario.*');
	}
}