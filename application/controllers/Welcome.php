<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function index()
	{
		if($this->session->userdata('usuario_id'))
		{
			header('Location: '.base_url().'index.php/UsuariosController/mi_cuenta');
		}
		else
			$this->load->view('login');
	}

	public function Panel()
	{
		$this->load->view('index');
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

	public function enviar_correo() {
        $this->load->library('phpmailer_lib');

        $para = 'el_mts@hotmail.com';
        $asunto = 'Asunto del correo';
        $mensaje = 'Contenido del mensaje';

        if ($this->phpmailer_lib->enviar_correo($para, $asunto, $mensaje)) {
            echo 'El correo se envió correctamente.';
        } else {
            echo 'Error al enviar el correo.';
        }
    }

}
