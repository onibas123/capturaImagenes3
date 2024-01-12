<?php
class ConfiguracionesController extends CI_Controller {

	function __construct()
	{
		parent::__construct();
	}
	
	public function index()
	{
		$this->load->library('grocery_CRUD');
		$crud = new grocery_CRUD();
		$crud->set_table('configuraciones');
		$crud->set_subject('Parámetro');
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
        
		$crud->required_fields('parametro');
        $crud->required_fields('valor');
        $crud->required_fields('tipo');

		$output = $crud->render();
		$data = (array)$output;
		$data['titulo'] = 'Parámetrica';
		$this->load->view('configuraciones/index', $data);
	}
}