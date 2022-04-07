<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleSensor extends Model
{
	use HasFactory;
	public $timestamps = false;
	protected $table = 'DetalleSensor';

	protected $fillable =
	[
		'id_sensor',
		'id_detalle_habitacion'
	];
}