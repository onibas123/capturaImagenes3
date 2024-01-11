<?php
class DahuaController extends CI_Controller {

	function __construct()
	{
		parent::__construct();
	}

	public function obtenerCapturaCanal(){
		// Configuración del NVR Dahua
		$nvrIP = '192.168.1.3'; // Cambia esto con la dirección IP de tu NVR
		$usuarioNVR = 'tu_usuario';
		$claveNVR = 'tu_clave';

		// ID de la cámara en el NVR (puede variar según la configuración del NVR)
		$idCamara = 1;

		// URL de la API para obtener una captura de la cámara desde el NVR
		$apiUrl = "http://$nvrIP/cgi-bin/snapshot.cgi?channel=$idCamara";

		// Construir las credenciales para la solicitud
		$credencialesNVR = base64_encode("$usuarioNVR:$claveNVR");

		// Configurar las opciones de la solicitud HTTP
		$opciones = [
			'http' => [
				'header' => "Authorization: Basic $credencialesNVR"
			]
		];

		// Crear el contexto de la solicitud
		$contexto = stream_context_create($opciones);

		// Hacer la solicitud HTTP y obtener la captura de imagen
		$imagen = file_get_contents($apiUrl, false, $contexto);

		// Verificar si la captura se obtuvo correctamente
		if ($imagen !== false) {
			// Guardar la imagen en un archivo
			file_put_contents('captura.jpg', $imagen);
			echo 'Captura de imagen exitosa.';
		} else {
			echo 'Error al obtener la imagen.';
		}
	}
}