<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ControladorSensor extends Controller
{
    //CRUD Habitacion

    public function CrearHabitacion(Request $request)
    {
        $habitacion = new Habitacion();
        $habitacion->nombre = $request['nombre'];
        $habitacion->save();
        return $habitacion;
    }

    public function ActualizarHabitacion(Request $request, $id)
    {
        $habitacion = Habitacion::find($id);
        if ($habitacion == null)
            return response()->json(['error' => 'La habitacion no existe'], Response::HTTP_NOT_FOUND);
        $habitacion->nombre = $request['nombre'];
        $habitacion->save();
        return $habitacion;
    }


    public function EliminarHabitacion($id)
    {
        $habitacion = Habitacion::find($id);
        if ($habitacion == null)
            return response()->json(['error' => 'La habitacion no existe'], Response::HTTP_NOT_FOUND);
        $habitacion->delete();
        return response()->json(['success' => 'La habitacion ha sido eliminada'], Response::HTTP_OK);
    }

    public function ObtenerHabitacion($id)
    {
        $habitacion = Habitacion::find($id);
        if ($habitacion == null)
            return response()->json(['error' => 'La habitacion no existe'], Response::HTTP_NOT_FOUND);
        return $habitacion;
    }


    public function ObtenerHabitaciones()
    {
        $habitaciones = Habitacion::all();
        return $habitaciones;
    }
    


}
