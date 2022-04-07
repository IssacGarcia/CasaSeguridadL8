<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ControladorDetHabitacion extends Controller
{
    public function index(){
        $detalleHabitaciones = DetalleHabitacion::all();
        return $detalleHabitaciones;
    }

    public function store(Request $request){
        $detalleHabitacion = new DetalleHabitacion();
        $detalleHabitacion->id_habitacion = $request['id_habitacion'];
        $detalleHabitacion->id_detalle_casa = $request['id_detalle_casa'];
        $detalleHabitacion->save();
        return $detalleHabitacion;
    }

    public function show($id){
        $detalleHabitacion = DetalleHabitacion::find($id);
        if ($detalleHabitacion == null)
            return response()->json(['error' => 'La detalleHabitacion no existe'], Response::HTTP_NOT_FOUND);
        return $detalleHabitacion;
    }

    public function update(Request $request, $id){
        $detalleHabitacion = DetalleHabitacion::find($id);
        if ($detalleHabitacion == null)
            return response()->json(['error' => 'La detalleHabitacion no existe'], Response::HTTP_NOT_FOUND);
        $detalleHabitacion->id_habitacion = $request['id_habitacion'];
        $detalleHabitacion->id_detalle_casa = $request['id_detalle_casa'];
        $detalleHabitacion->save();
        return $detalleHabitacion;
    }

    public function destroy($id){
        $detalleHabitacion = DetalleHabitacion::find($id);
        if ($detalleHabitacion == null)
            return response()->json(['error' => 'La detalleHabitacion no existe'], Response::HTTP_NOT_FOUND);
        $detalleHabitacion->delete();
        return response()->json(['success' => 'La detalleHabitacion ha sido eliminada'], Response::HTTP_OK);
    }
    

}
