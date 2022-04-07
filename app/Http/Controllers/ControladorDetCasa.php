<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ControladorDetCasa extends Controller
{
    public function index(){
        $detalleCasa = DetalleCasa::all();
        return $detalleCasa;
    }
    public function store(Request $request){
        $detalleCasa = new DetalleCasa();
        $detalleCasa->id_casa = $request['id_casa'];
        $detalleCasa->id_detalle_sensor = $request['id_detalle_sensor'];
        $detalleCasa->save();
        return $detalleCasa;
    }
    public function show($id){
        $detalleCasa = DetalleCasa::find($id);
        if ($detalleCasa == null)
            return response()->json(['error' => 'La detalleCasa no existe'], Response::HTTP_NOT_FOUND);
        return $detalleCasa;
    }

    public function update(Request $request, $id){
        $detalleCasa = DetalleCasa::find($id);
        if ($detalleCasa == null)
            return response()->json(['error' => 'La detalleCasa no existe'], Response::HTTP_NOT_FOUND);
        $detalleCasa->id_casa = $request['id_casa'];
        $detalleCasa->id_detalle_sensor = $request['id_detalle_sensor'];
        $detalleCasa->save();
        return $detalleCasa;
    }

    public function destroy($id){
        $detalleCasa = DetalleCasa::find($id);
        if ($detalleCasa == null)
            return response()->json(['error' => 'La detalleCasa no existe'], Response::HTTP_NOT_FOUND);
        $detalleCasa->delete();
        return response()->json(['success' => 'La detalleCasa ha sido eliminada'], Response::HTTP_OK);
    }
}
