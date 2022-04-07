<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleHabitacion extends Model
{
	use HasFactory;
	public $timestamps = false;
	protected $table = 'DetalleHabitacion';

	protected $fillable =
	[
		'id_habitacion',
		'id_detalle_casa'
	];
}