<?php
class OpcionesController extends CI_Controller {

	function __construct()
	{
		parent::__construct();
	}
	
	public function index()
	{
		$this->load->library('grocery_CRUD');
		$crud = new grocery_CRUD();
		$crud->set_table('opciones');
		$crud->set_subject('Opción');
		$crud->set_language('spanish');

		$crud->unset_print();
		$crud->unset_export();
		$crud->unset_clone();
		if($this->session->userdata('usuario_guarda') == 0)
			$crud->unset_add();
		if($this->session->userdata('usuario_edita') == 0)
			$crud->unset_edit();
		if($this->session->userdata('usuario_elimina') == 0)
			$crud->unset_delete();
		$crud->set_relation('padre','opciones','nombre');
		$crud->required_fields('nombre');
        $crud->required_fields('nivel');
        $crud->required_fields('orden');
        $crud->required_fields('padre');

		$output = $crud->render();
		$data = (array)$output;
		$data['titulo'] = 'Opciones';
		$this->load->view('opciones/index', $data);
	}
}