<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Casa;
use App\Models\Dueño;
use App\Models\Invitado;
use App\Models\DetalleCasa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class ControladorCasa extends Controller
{
	// GET -> Ver una casa del usuario
	public function ver(int $id)
	{
		$casa = Auth::user()->casa($id);
		if ($casa == null)
			return response()->json(['error' => 'La casa no existe'], Response::HTTP_NOT_FOUND);
		return response()->json($casa, Response::HTTP_OK);
	}

	// GET -> Ver todas las casas del usuario
	public function ver_todas()
	{
		$casas = Auth::user()->dueño?->casas;
		return response()->json($casas, Response::HTTP_OK);
	}

	// GET -> Ver una casa a la que el usuario está invitado
	public function ver_inv(int $id)
	{
		$casa = Auth::user()->casa_invitado($id);
		if ($casa == null)
			return response()->json(['error' => 'La casa no existe'], Response::HTTP_NOT_FOUND);
		return response()->json($casa, Response::HTTP_OK);
	}

	// GET -> Ver todas las casas a las que el usuario está invitado
	public function ver_todas_inv()
	{
		$casas = Auth::user()->invitado?->casas;
		return response()->json($casas, Response::HTTP_OK);
	}

	// POST -> Crea una nueva casa
	public function crear(Request $request)
	{
		$validacion = Validator::make($request->all(),
		[
			'nombre' => ['string'],
			'direccion' => ['required', 'string', 'unique:Casa']
		]);

		if ($validacion->fails())
			return response()->json($validacion->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);

		// Se crea la casa
		$casa = Casa::create($validacion->validated());

		// Se marca el usuario actual como dueño
		$usuario = Auth::user();
		$usuario->marcar_como_dueño();

		// Se enlaza la casa con el usuario
		DetalleCasa::create(
		[
			'id_casa' => $casa->id,
			'id_dueño' => $usuario->dueño->id,
			'id_invitado' => null
		]);

		return response()->json($casa, Response::HTTP_CREATED);
	}

	// DELETE -> Elimina una casa
	public function eliminar(int $id)
	{
		$casa = Casa::find($id);
		$usuario = Auth::user();

		// Se verifica que la casa exista
		if ($casa == null)
			return response()->json(['error' => 'La casa no existe'], Response::HTTP_NOT_FOUND);

		// Se verifica que el usuario sea el dueño de la casa
		if ($usuario->casa($id) == null)
			return response()->json(['error' => 'El usuario no es dueño de la casa solicitada'], Response::HTTP_FORBIDDEN);

		// Se quitan todos los invitados de la casa
		$casa->invitados->each(function($invitado) use (&$id, &$usuario)
		{
			$usuario->quitar_invitado($id, $invitado->id); 
		});

		// Se elimina la casa
		$casa->detalles_casa()->delete();
		$casa->delete();

		// Si el usuario no es dueño de ninguna casa, se elimina de la tabla de dueños
		if (!$usuario->es_dueño())
			$usuario->dueño->delete();

		return response()->json(['mensaje' => 'Casa eliminada'], Response::HTTP_OK);
	}
}