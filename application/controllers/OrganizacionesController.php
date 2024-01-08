<?php
class OrganizacionesController extends CI_Controller {

	function __construct()
	{
		parent::__construct();
	}
	
	public function index()
	{
		$this->load->library('grocery_CRUD');
		$crud = new grocery_CRUD();
		$crud->set_table('organizaciones');
		$crud->set_subject('Organización');
		$crud->set_language('spanish');

		$crud->unset_print();
		$crud->unset_export();
		$crud->unset_clone();
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
		$data['titulo'] = 'Organizaciones';
		$this->load->view('organizaciones/index', $data);
	}
}