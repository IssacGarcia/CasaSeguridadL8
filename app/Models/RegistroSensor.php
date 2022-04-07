<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistroSensor extends Model
{
	use HasFactory;
	public $timestamps = false;
	protected $table = 'RegistroSensor';

	protected $fillable =
	[
		'valor',
		'fecha',
		'id_detalle_sensor'
	];
}