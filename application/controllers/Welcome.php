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

}
