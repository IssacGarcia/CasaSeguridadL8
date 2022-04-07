<?php

namespace App\Http\Controllers;

//require 'vendor/autoload.php';

use App\Models\Sensor;
use App\Models\DetalleSensor;
use App\Models\RegistroSensor;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;

class ControladorAdafruit extends Controller
{
   /* public function ChecarExistencia()
    {
		$client = new Client();

		return $client->request('GET', 'https://io.adafruit.com/api/v2/nayelireyes/feeds/recibirluz/data',
		['headers' => ['X-AIO-Key' => 'aio_bpxh47xyPzAUqcU4YSgvEL0vJPCA']])->getBody();
    }	*/
	/*metodo para sacar el ultimo dato de adafruit*/	
	public function ChecarExistencia()
	{
		$client = new Client();

		$resultado = $client->request('GET', 'https://io.adafruit.com/api/v2/nayelireyes/feeds/ledbtn/data',
		['headers' => ['X-AIO-Key' => 'aio_sifF92s6F8SJmGy7w5nERaDr5aw9']])->getBody();
		$busqueda = Sensor::firstWhere('nombre', '=', 'Led');

		if ($busqueda == null)
		{
			$sensor = Sensor::create(['nombre' => 'Led']);
			// Se liga a la tabla de Detalle Sensor
		}

		$registro = RegistroSensor::create(
		[
			'valor' => $valor,
			'fecha' => $fecha
			// 'id_detalle_sensor' => $sensor->id  *MAL*
		]);

		return $registro;

	}


	public function CambiarLed(Request $request)
	{
		$client = new Client();

		$resultado = $client->request('POST', 'https://io.adafruit.com/api/v2/nayelireyes/feeds/ledbtn/data/last',
		[
			'headers' => ['X-AIO-Key' => 'aio_sifF92s6F8SJmGy7w5nERaDr5aw9'],
			'form_params' => ['value' => $request['led']]
		])
		->getBody();
		$valor = json_decode($resultado)->value;
		$fecha = json_decode($resultado)->created_at;
		return['valor'=>$valor
		,'fecha'=>$fecha];
/*
		$busqueda = Sensor::firstWhere('nombre', '=', 'Clave');

		if ($busqueda == null)
		{
			$sensor = Sensor::create(['nombre' => 'Clave']);
			// Se liga a la tabla de Detalle Sensor
		}

		$registro = RegistroSensor::create(
		[
			'valor' => $valor,
			'fecha' => $fecha
			// 'id_detalle_sensor' => $sensor->id  *MAL*
		]);

		return $registro;
		*/
	}

	public function Luminosidad()
	{
		$client = new Client();
		$resultado = $client->request('GET', 'https://io.adafruit.com/api/v2/nayelireyes/feeds/luminosidad/data/last',
		['headers' => ['X-AIO-Key' => 'aio_sifF92s6F8SJmGy7w5nERaDr5aw9']])->getBody();

		$valor = json_decode($resultado)->value;
		$fecha = json_decode($resultado)->created_at;

		return['valor'=>$valor
		,'fecha'=>$fecha];
/*
		$busqueda = Sensor::firstWhere('nombre', '=', 'Luminosidad');

		if ($busqueda == null)
		{
			$sensor = Sensor::create(['nombre' => 'Luminosidad']);
			// Se liga a la tabla de Detalle Sensor
		}

		$registro = RegistroSensor::create(
		[
			'valor' => $valor,
			'fecha' => $fecha
			// 'id_detalle_sensor' => $sensor->id  *MAL*
		]);

		return $registro;
*/
	}
	


	public function Distancia()
	{
		$client = new Client();

		$resultado = $client->request('GET', 'https://io.adafruit.com/api/v2/nayelireyes/feeds/distancia/data/last',
		['headers' => ['X-AIO-Key' => 'aio_sifF92s6F8SJmGy7w5nERaDr5aw9']])->getBody();
		$valor = json_decode($resultado)->value;
		$fecha = json_decode($resultado)->created_at;

		return['valor'=>$valor
		,'fecha'=>$fecha];
/*
		$busqueda = Sensor::firstWhere('nombre', '=', 'Distancia');

		if ($busqueda == null)
		{
			$sensor = Sensor::create(['nombre' => 'Distancia']);
			// Se liga a la tabla de Detalle Sensor
		}

		$registro = RegistroSensor::create(
		[
			'valor' => $valor,
			'fecha' => $fecha
			// 'id_detalle_sensor' => $sensor->id  *MAL*
		]);

		return $registro;
		*/
	}

	public function Temperatura()
	{
		$client = new Client();

		$resultado = $client->request('GET', 'https://io.adafruit.com/api/v2/nayelireyes/feeds/temperatura/data/last',
		['headers' => ['X-AIO-Key' => 'aio_sifF92s6F8SJmGy7w5nERaDr5aw9']])->getBody();

		$valor = json_decode($resultado)->value;
		$fecha = json_decode($resultado)->created_at;

		return['valor'=>$valor
		,'fecha'=>$fecha];
/*
		$busqueda = Sensor::firstWhere('nombre', '=', 'Temperatura');

		if ($busqueda == null)
		{
			$sensor = Sensor::create(['nombre' => 'Temperatura']);
			// Se liga a la tabla de Detalle Sensor
		}

		$registro = RegistroSensor::create(
		[
			'valor' => $valor,
			'fecha' => $fecha
			// 'id_detalle_sensor' => $sensor->id  *MAL*
		]);

		return $registro;
*/
	}

	public function ObtenerClave()
	{
		$client = new Client();

		$resultado = $client->request('GET', 'https://io.adafruit.com/api/v2/nayelireyes/feeds/numpad/data/last',
		['headers' => ['X-AIO-Key' => 'aio_sifF92s6F8SJmGy7w5nERaDr5aw9']])->getBody();

		$valor = json_decode($resultado)->value;
		$fecha = json_decode($resultado)->created_at;

		return['valor'=>$valor
				,'fecha'=>$fecha];
	/*	$busqueda = Sensor::firstWhere('nombre', '=', 'Clave');

		if ($busqueda == null)
		{
			$sensor = Sensor::create(['nombre' => 'Clave']);
			// Se liga a la tabla de Detalle Sensor
		}

		$registro = RegistroSensor::create(
		[
			'valor' => $valor,
			'fecha' => $fecha
			// 'id_detalle_sensor' => $sensor->id  *MAL*
		]);

		return $registro;*/ 
	}
}