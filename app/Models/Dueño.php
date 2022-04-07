<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dueño extends Model
{
	use HasFactory;
	public $timestamps = false;
	protected $table = 'Dueño';

	protected $fillable =
	[
		'alias',
		'id_usuario'
	];

	public function detalles_casa()
	{
		return $this->hasMany(DetalleCasa::class, 'id_dueño');
	}

	public function casas()
	{
		$detalles_casa = $this->detalles_casa();
		return $detalles_casa->join('Casa', 'Casa.id', '=', 'DetalleCasa.id_casa')
			->select('Casa.*')->distinct();
	}
}