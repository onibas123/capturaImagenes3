<?php
class DispositivosController extends CI_Controller {

	function __construct()
	{
		parent::__construct();
	}
	
	public function index()
	{
		$this->load->library('grocery_CRUD');
		$crud = new grocery_CRUD();
		$crud->set_table('dispositivos');
		$crud->set_subject('Dispositivo');
		$crud->set_language('spanish');

		$crud->unset_print();
		$crud->unset_export();
		$crud->unset_clone();
        $crud->set_relation('organizaciones_id','organizaciones','nombre');
        $crud->set_relation('tipo_dispositivo_id','tipo_dispositivo','nombre');
		$crud->set_relation('marcas_id','marcas','nombre');
		$crud->columns(['id','organizaciones_id','tipo_dispositivo_id', 'marcas_id', 'nombre', 'cantidad_canales', 'ip', 'puerto', 'estado', 'codificar_dss']);
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
		$data['titulo'] = 'Dispositivos';
		$this->load->view('dispositivos/index', $data);
	}
}