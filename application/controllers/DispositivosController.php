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
		$crud->display_as('organizaciones_id','Organización')->display_as('tipo_dispositivo_id','Tipo')
		->display_as('marcas_id','Marca')->display_as('cantidad_canales','Canales')->display_as('codificar_dss', 'DSS');
		$crud->columns(['organizaciones_id','tipo_dispositivo_id', 'marcas_id', 'nombre', 'cantidad_canales', 'ip', 'puerto', 'usuario', 'password', 'estado', 'codificar_dss']);
		$crud->field_type('password', 'password');
		
		if($this->session->userdata('usuario_guarda') == 0)
			$crud->unset_add();
		if($this->session->userdata('usuario_edita') == 0)
			$crud->unset_edit();
		if($this->session->userdata('usuario_elimina') == 0)
			$crud->unset_delete();
		
		$output = $crud->render();
		$data = (array)$output;
		$data['titulo'] = 'Dispositivos';
		$this->load->view('dispositivos/index', $data);
	}
}