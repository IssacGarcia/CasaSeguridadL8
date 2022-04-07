<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Usuario extends Authenticatable implements JWTSubject
{
	use HasFactory;
	public $timestamps = false;
	protected $table = 'Usuario';

	protected $fillable =
	[
		'email',
		'password',
		'nombre',
		'apellidos',
		'telefono'
	];

	protected $hidden =
	[
		'password'
	];

	public function dueño()
	{
		return $this->hasOne(Dueño::class, 'id_usuario');
	}

	public function invitado()
	{
		return $this->hasOne(Invitado::class, 'id_usuario');
	}

	public function es_dueño()
	{
		if (!$this->dueño()->exists())
			return false;
		$id_dueño = $this->dueño->id;
		return (bool) DetalleCasa::where('id_dueño', $id_dueño)->exists();
	}

	public function es_invitado()
	{
		if (!$this->invitado()->exists())
			return false;
		$id_invitado = $this->invitado->id;
		return (bool) DetalleCasa::where('id_invitado', $id_invitado)->exists();
	}

	public function marcar_como_dueño()
	{
		if ($this->es_dueño())
			return;
		Dueño::create(
		[
			'alias' => $this->nombre,
			'id_usuario' => $this->id
		]);
	}

	public function marcar_como_invitado()
	{
		if ($this->es_invitado())
			return;
		Invitado::create(
		[
			'alias' => $this->nombre,
			'id_usuario' => $this->id
		]);
	}

	public function casa(int $id_casa)
	{
		if (!$this->es_dueño())
			return null;
		return $this->dueño->casas->find($id_casa);
	}

	public function casa_invitado(int $id_casa)
	{
		if (!$this->es_invitado())
			return null;
		return $this->invitado->casas->find($id_casa);
	}

	public function agregar_invitado(int $id_casa, int $id_usuario)
	{
		// Se busca al usuario invitado segun su id
		$usuario = Usuario::find($id_usuario);

		// Se marca el usuario como invitado
		$usuario->marcar_como_invitado();

		// Se enlaza el invitado con la casa y el dueño
		DetalleCasa::create(
		[
			'id_casa' => $id_casa,
			'id_dueño' => $this->dueño->id,
			'id_invitado' => $usuario->invitado->id
		]);
	}

	public function quitar_invitado(int $id_casa, int $id_usuario)
	{
		// Se busca al invitado segun su id
		$usuario = Usuario::find($id_usuario);

		// Se busca el enlace del invitado con la casa y el dueño y se elimina
		$detalle_casa = DetalleCasa::where('id_casa', $id_casa)
			->where('id_dueño', $this->dueño->id)
			->where('id_invitado', $usuario->invitado->id)
			->delete();

		// Si el usuario ya no es invitado en ninguna casa, se elimina de la tabla de invitados
		if (!$usuario->es_invitado())
			$usuario->invitado->delete();
	}

	public function eliminar()
	{
		// Se borran todas las casas del usuario
		// Se borran las invitaciones del usuario
	}

	public function getJWTIdentifier() { return $this->getKey(); }
	public function getJWTCustomClaims() { return []; }
}