<?php
class HikvisionController extends CI_Controller {

	function __construct()
	{
		parent::__construct();
	}

	public function obtenerCapturaCanal($organizacion_id, $ip, $puerto, $usuario, $clave){
		// Configuración Hikvision
		$ip = $ip.':'.$puerto;
		// ID de la camara en el NVR (puede variar según la configuración del NVR)
		$idCamara = 1;
		// URL de la API para obtener una captura de la camara desde el NVR
		$apiUrl = "http://$ip/ISAPI/Streaming/channels/$idCamara/picture";
		// Construir las credenciales para la solicitud
		$credenciales = base64_encode("$usuario:$clave");
		// Configurar las opciones de la solicitud HTTP
		$opciones = [
			'http' => [
				'header' => "Authorization: Basic $credenciales"
			]
		];
		// Crear el contexto de la solicitud
		$contexto = stream_context_create($opciones);
		// Hacer la solicitud HTTP y obtener la captura de imagen
		$imagen = file_get_contents($apiUrl, false, $contexto);
		// Verificar si la captura se obtuvo correctamente
		if ($imagen !== false) {
			// Guardar la imagen en un archivo
			$nombre_imagen = 'captura_'.$organizacion_id.'_'.$idCamara.'_'.date('YmdHis').'.jpg';
			file_put_contents('./assets/imagenes_capturadas/'.$nombre_imagen, $imagen);
			return $nombre_imagen;
		} else {
			return false;
		}
	}

	public function addLog($entidad, $accion, $data){
		$usuarios_id = !empty($this->session->userdata('usuario_id')) ? $this->session->userdata('usuario_id') : '';
		$fecha_hora = date('Y-m-d H:i:s');
	
		$data_to_save = 	[
								'usuarios_id' => $usuarios_id,
								'entidad' => $entidad,
								'fecha_hora' => $fecha_hora,
								'accion' => $accion,
								'data' => $data
							];
							
		if($this->db->insert('logs', $data_to_save))
			return true;
		else
			return false;
	}
}