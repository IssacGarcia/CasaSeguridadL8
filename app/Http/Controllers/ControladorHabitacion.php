<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Casa;
use App\Models\Habitacion;
use App\Models\Dueño;
use App\Models\Invitado;
use App\Models\DetalleCasa;
use App\Models\DetalleHabitacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class ControladorHabitacion extends Controller
{
  /*Ver habitaciones de la casa*/

	public function ver(int $id)
	{
		$habitacion = Habitacion::find($id);
		if ($habitacion == null)
		return response()->json(['error' => 'La habitacion no existe'], Response::HTTP_NOT_FOUND);
		return response()->json($habitacion, Response::HTTP_OK);
	}

	/*Ver todas las habitaciones de la casa*/

	public function ver_todas()
	{
		$habitaciones = Habitacion::all();
		return response()->json($habitaciones, Response::HTTP_OK);
	}

	/*agrega una habitacion en la casa*/

	public function agregar_habitacion(Request $request)
	{
		$validacion = Validator::make($request->all(),
		[
			'nombre' => ['string']
		]);

		if ($validacion->fails())
			return response()->json($validacion->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);

			//se marca la casa actual como dueña de las habitaciones

			$casa = Auth::user()->casa;
			$casa->habitaciones()->create($request->all());
			return response()->json($casa, Response::HTTP_OK);
	
			$habitacion = new Habitacion();
		$habitacion->nombre = $request->nombre;
		$habitacion->save();

		DetalleHabitacion::create([
			'id_habitacion' => $habitacion->id,
			'id_casa' => $casa->id
		]);

		return response()->json($habitacion, Response::HTTP_CREATED);
	}

	/*editar una habitacion en la casa*/
	
	public function editar_habitacion(Request $request, $id)
	{
		$validacion = Validator::make($request->all(),
		[
			'nombre' => ['string']
		]);

		if ($validacion->fails())
			return response()->json($validacion->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);

		$habitacion = Habitacion::find($id);
		if ($habitacion == null)
			return response()->json(['error' => 'La habitacion no existe'], Response::HTTP_NOT_FOUND);

		$habitacion->nombre = $request->nombre;
		$habitacion->save();

		return response()->json($habitacion, Response::HTTP_OK);
	}

	//DELETE-> Elimina una habitacion de la casa
	public function eliminar_habitacion(int $id)
	{
		$habitacion = Habitacion::find($id);
		$casa = $habitacion->casa;

		// Se verifica que la habitacion exista
		if ($habitacion == null)
			return response()->json(['error' => 'La habitacion no existe'], Response::HTTP_NOT_FOUND);

		// Se elimina la habitacion
		$habitacion->detalles_habitaciones()->delete();
		$habitacion->delete();

		//si la habitacion no pertenece a ninguna casa se eliminara
		if ($casa->habitaciones->count() == 0)
			$casa->delete();
		
		return response()->json(['success' => 'La habitacion fue eliminada'], Response::HTTP_OK);
	}   


}
