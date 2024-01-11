<?php
class TipoDispositivoController extends CI_Controller {

	function __construct()
	{
		parent::__construct();
	}
	
	public function index()
	{
		$this->load->library('grocery_CRUD');
		$crud = new grocery_CRUD();
		$crud->set_table('tipo_dispositivo');
		$crud->set_subject('Tipo de Dispositivo');
		$crud->set_language('spanish');

		$crud->unset_print();
		$crud->unset_export();
		$crud->unset_clone();

		$crud->unset_add();
		$crud->unset_edit();
		$crud->unset_delete();

		/*
        if($this->session->userdata('usuario_escribir') == 0)
			$crud->unset_add();
		if($this->session->userdata('usuario_editar') == 0)
			$crud->unset_edit();
		if($this->session->userdata('usuario_eliminar') == 0)
			$crud->unset_delete();
        */
		//$crud->set_relation('padre','opciones','nombre');

		$output = $crud->render();
		$data = (array)$output;
		$data['titulo'] = 'Tipos de Dispositivos';
		$this->load->view('tipo_dispositivo/index', $data);
	}
}