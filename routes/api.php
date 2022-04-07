<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;


// ingresar    -> Inicia sesión
// registrarse -> Crea un usuario
Route::prefix('usuario')->group(function()
{
	Route::post('ingresar',    [ControladorUsuario::class, 'ingresar']);
	Route::post('registrarse', [ControladorUsuario::class, 'registrarse']);
});


// cuenta    -> Ver los datos del usuario actual
// salir     -> Cierra sesión del usuario actual
// editar    -> Edita los datos del usuario actual
// eliminar  -> Elimina el usuario actual

Route::prefix('usuario')->middleware('auth')->group(function()
{
	// Funciones generales de cuenta
	Route::get   ('cuenta',          [ControladorUsuario::class, 'cuenta']);
	Route::get   ('salir',           [ControladorUsuario::class, 'salir']);
	Route::put   ('editar',          [ControladorUsuario::class, 'editar']);
	Route::delete('eliminar',        [ControladorUsuario::class, 'eliminar']);
	// refrescar -> Crea un nuevo token para el usuario actual
	//////////////////////////////////////////////////////////////////////////////
	Route::get   ('regenerar_token', [ControladorUsuario::class, 'regenerar_token']);
});


// agregar_invitado -> Agrega un usuario existente como invitado a una casa
// crear_invitado   -> Crea un usuario nuevo como invitado a una casa
// quitar_invitado  -> Quita un invitado de una casa
Route::prefix('usuario')->middleware('auth')->group(function()
{
	
	// Funciones de invitado
	Route::get    ('agregar_invitado/{id_casa}/{email}',     [ControladorUsuario::class, 'agregar_invitado']);
	Route::get    ('crear_invitado/{id_casa}',               [ControladorUsuario::class, 'crear_invitado']);
	Route::delete ('quitar_invitado/{id_casa}/{id_usuario}', [ControladorUsuario::class, 'quitar_invitado']);

	// TEMPORAL | Prueba
	Route::post('prueba', 'ControladorUsuario@prueba');
});

// ver       -> Ver una de las casas del usuario conectado
// ver_todas -> Ver todas las casas del usuario conectado
// ver_inv   -> Ver una de las casas a las que el usuario conectado está invitado
// ver_inv_t -> Ver todas las casas a las que el usuario conectado está invitado
// crear     -> Crea una nueva casa para el usuario conectado
// eliminar  -> Elimina una casa del usuario conectado
Route::prefix('casa')->middleware('auth')->group(function()
{
	Route::get   ('ver/{id}',      [ControladorCasa::class, 'ver']);
	Route::get   ('ver_todas',     [ControladorCasa::class, 'ver_todas']);
	Route::get   ('ver_inv/{id}',  [ControladorCasa::class, 'ver_inv']);
	Route::get   ('ver_todas_inv', [ControladorCasa::class, 'ver_todas_inv']);
	Route::post  ('crear',         [ControladorCasa::class, 'crear']);
	Route::delete('eliminar/{id}', [ControladorCasa::class, 'eliminar']);
});

Route::any('no_autorizado', function()
{
	return response()->json(['error' => 'No Autorizado'], Response::HTTP_UNAUTHORIZED);
})
->name('no_autorizado');

Route::prefix('DetHabitacion')->group(function()
{
	Route::get('ver', [ControladorDetSensor::class, 'index']);
	Route::post('crear', [ControladorDetSensor::class, 'store']);
	Route::get('ver/{id}', [ControladorDetSensor::class, 'show']);
	Route::put('editar/{id}', [ControladorDetSensor::class, 'update']);
	Route::delete('eliminar/{id}', [ControladorDetSensor::class, 'destroy']);
});

Route::prefix('DetCasa')->group(function()
{
	Route::get('ver', [ControladorDetCasa::class, 'index']);
	Route::post('crear', [ControladorDetCasa::class, 'store']);
	Route::get('ver/{id}', [ControladorDetCasa::class, 'show']);
	Route::put('editar/{id}', [ControladorDetCasa::class, 'update']);
	Route::delete('eliminar/{id}', [ControladorDetCasa::class, 'destroy']);
});

Route:: prefix('DetSensor')->group(function()
{
	Route::get('ver', [ControladorDetSensor::class, 'index']);
	Route::post('crear', [ControladorDetSensor::class, 'store']);
	Route::get('ver/{id}', [ControladorDetSensor::class, 'show']);
	Route::put('editar/{id}', [ControladorDetSensor::class, 'update']);
	Route::delete('eliminar/{id}', [ControladorDetSensor::class, 'destroy']);
});

	
Route::prefix('sensores')->group(function()
{
	Route::get ('ultimo_dato', [ControladorAdafruit::class, 'ChecarExistencia']);
	Route::post('CambiarLed',[ControladorAdafruit::class, 'CambiarLed']);
	Route::get('CambiarLed',[ControladorAdafruit::class, 'CambiarLed']);
	Route::get('Luminosidad',[ControladorAdafruit::class, 'Luminosidad']);
	Route::post('ChecarExistencia',[ControladorAdafruit::class, 'ChecarExistencia']);
	Route::get('Distancia', [ControladorAdafruit::class, 'Distancia']);
	Route::get('Temperatura',[ControladorAdafruit::class, 'Temperatura']);
	Route::get('ObtenerClave', [ControladorAdafruit::class, 'ObtenerClave']);
});

