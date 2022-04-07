<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleCasa extends Model
{
	use HasFactory;
	public $timestamps = false;
	protected $table = 'DetalleCasa';

	protected $fillable =
	[
		'id_casa',
		'id_dueño',
		'id_invitado'
	];
}