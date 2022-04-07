<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ControladorDetSensor extends Controller
{
    public function index(){
        $detalleSensor = DetalleSensor::all();
        return $detalleSensor;
    }

    public function store(Request $request){
        $detalleSensor = new DetalleSensor();
        $detalleSensor->id_sensor = $request['id_sensor'];
        $detalleSensor->id_detalle_habitacion = $request['id_detalle_habitacion'];
        $detalleSensor->save();
        return $detalleSensor;
    }

    public function show($id){
        $detalleSensor = DetalleSensor::find($id);
        if ($detalleSensor == null)
            return response()->json(['error' => 'La detalleSensor no existe'], Response::HTTP_NOT_FOUND);
        return $detalleSensor;
    }

    public function update(Request $request, $id){
        $detalleSensor = DetalleSensor::find($id);
        if ($detalleSensor == null)
            return response()->json(['error' => 'La detalleSensor no existe'], Response::HTTP_NOT_FOUND);
        $detalleSensor->id_sensor = $request['id_sensor'];
        $detalleSensor->id_detalle_habitacion = $request['id_detalle_habitacion'];
        $detalleSensor->save();
        return $detalleSensor;
    }

    public function destroy($id){
        $detalleSensor = DetalleSensor::find($id);
        if ($detalleSensor == null)
            return response()->json(['error' => 'La detalleSensor no existe'], Response::HTTP_NOT_FOUND);
        $detalleSensor->delete();
        return response()->json(['success' => 'La detalleSensor ha sido eliminada'], Response::HTTP_OK);
    }
}
