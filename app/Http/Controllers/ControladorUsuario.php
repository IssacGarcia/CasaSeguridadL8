<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Dueño;
use App\Models\Casa;
use App\Models\Invitado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

use App\Models\DetalleCasa;

class ControladorUsuario extends Controller
{
	// POST | Ingresar
	public function ingresar(Request $solicitud)
	{
		$validacion = Validator::make($solicitud->all(),
		[
			'email' => ['required', 'email'],
			'password' => ['required', 'string']
		]);

		if ($validacion->fails())
			return response()->json($validacion->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);

		if (!$token = Auth::attempt($validacion->validated()))
			return redirect('api/no_autorizado');

		return $this->formatear_token($token);
	}

	// POST | Registrarse
	public function registrarse(Request $solicitud)
	{
		$validacion = Validator::make($solicitud->all(),
		[
			'email' => ['required', 'email', 'unique:Usuario'],
			'password' => ['required', 'string', 'min:4'],
			'nombre' => ['string'],
			'apellidos' => ['string'],
			'telefono' => ['string']
		]);

		if ($validacion->fails())
			return response()->json($validacion->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);

		$usuario = $validacion->validated();
		$usuario['password'] = Hash::make($usuario['password']);
		$usuario = Usuario::create($usuario);
		$token = Auth::login($usuario);

		return $this->formatear_token($token);
	}

	// GET | Cuenta
	public function cuenta()
	{
		$usuario = Auth::user();
		return response()->json($usuario, Response::HTTP_OK);
	}

	// GET | Salir
	public function salir(Request $solicitud)
	{
		Auth::logout();
		return response()->json(['mensaje' => 'Sesion finalizada'], Response::HTTP_OK);
	}

	// PUT | Editar
	public function editar(Request $solicitud)
	{
		$usuario = Auth::user();
		if ($solicitud->password)
			$solicitud['password'] = Hash::make($solicitud->password);
		$usuario->update($solicitud->all());
		return response()->json($usuario, Response::HTTP_OK);
	}

	// DELETE | Eliminar
	public function eliminar()
	{
		Auth::user()->delete();
		return response()->json(['mensaje' => 'Usuario eliminado'], Response::HTTP_OK);
	}

	// GET | Regenerar Token
	public function regenerar_token()
	{
		return $this->formatear_token(Auth::refresh());
	}

	// GET | Agregar invitado
	public function agregar_invitado(int $id_casa, string $email)
	{
		$usuario = Auth::user();
		$casa = Casa::find($id_casa);
		$invitado = Usuario::where('email', $email)->first();

		// La casa debe existir
		if ($casa == null)
			return response()->json(['error' => 'La casa no existe'], Response::HTTP_NOT_FOUND);

		// El usuario invitado debe existir
		if ($invitado == null)
			return response()->json(['error' => 'El invitado no existe'], Response::HTTP_NOT_FOUND);

		// El usuario actual debe ser dueño de la casa
		if ($usuario->casa($id_casa) == null)
			return response()->json(['error' => 'No eres dueño de la casa'], Response::HTTP_CONFLICT);

		// No se puede volver a invitar al mismo usuario
		if ($casa->invitados->find($invitado->id) != null)
			return response()->json(['error' => 'El usuario ya es invitado'], Response::HTTP_CONFLICT);

		// El dueño de la casa no puede invitarse a si mismo
		if ($usuario->email == $invitado->email)
			return response()->json(['error' => 'No te puedes invitar a ti mismo'], Response::HTTP_CONFLICT);

		// Se enlaza la casa con el usuario invitado
		Auth::user()->agregar_invitado($id_casa, $invitado->id);
		return response()->json(['mensaje' => 'Invitado agregado'], Response::HTTP_OK);
	}

	// GET | Crear Invitado
	public function crear_invitado(int $id_casa)
	{
		$usuario = Auth::user();
		$casa = Casa::find($id_casa);

		// La casa debe existir
		if ($casa == null)
			return response()->json(['error' => 'La casa no existe'], Response::HTTP_NOT_FOUND);

		// El usuario actual debe ser dueño de la casa
		if ($usuario->casa($id_casa) == null)
			return response()->json(['error' => 'No eres dueño de la casa'], Response::HTTP_CONFLICT);

		// Se genera un correo para el invitado
		$indice = Invitado::select('*')->count() + 1;
		$email = $indice . '@invitado';

		// Si el correo ya existe, se genera uno nuevo con el siguiente indice
		while (Usuario::where('email', $email)->first())
		{
			$indice++;
			$email = $indice . '@invitado';
		}

		// Se crea el usuario invitado
		$invitado = Usuario::create(
		[
			'email' => $email,
			'password' => Hash::make('1234'),
			'nombre' => 'Invitado de ' . Auth::user()->nombre
		]);

		// Se enlaza la casa con el usuario invitado
		Auth::user()->agregar_invitado($id_casa, $invitado->id);
		return response()->json($invitado, Response::HTTP_OK);
	}

	// DELETE | Quitar Invitado
	public function quitar_invitado(int $id_casa, int $id_usuario)
	{
		$usuario = Auth::user();
		$casa = Casa::find($id_casa);
		$invitado = Usuario::find($id_usuario);

		// La casa debe existir
		if ($casa == null)
			return response()->json(['error' => 'La casa no existe'], Response::HTTP_NOT_FOUND);

		// El usuario invitado debe existir
		if ($invitado == null)
			return response()->json(['error' => 'El invitado no existe'], Response::HTTP_NOT_FOUND);

		// El usuario actual debe ser dueño de la casa
		if ($usuario->casa($id_casa) == null)
			return response()->json(['error' => 'No eres dueño de la casa'], Response::HTTP_CONFLICT);

		// No se puede quitar un usuario que no es invitado
		if ($casa->invitados->find($invitado->id) == null)
			return response()->json(['error' => 'El usuario no es invitado'], Response::HTTP_CONFLICT);

		// Se quita el enlace entre usuario invitado y la casa
		Auth::user()->quitar_invitado($id_casa, $id_usuario);
		return response()->json(['mensaje' => 'Invitado removido'], Response::HTTP_OK);
	}

	public function prueba()
	{
		return "PRUEBA";
	}

	// Crea un nuevo token de sesion
	private function formatear_token($token)
	{
		return response()->json(
		[
			'token' => $token,
			'tipo' => 'bearer',
			'expiracion' => Auth::factory()->getTTL() * 60
		],
		Response::HTTP_OK);
	}
}