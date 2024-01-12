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

		$crud->callback_before_insert(array($this,'add_log_create'));
		$crud->callback_before_update(array($this,'add_log_edit'));
		$crud->callback_before_delete(array($this,'add_log_delete'));
		
		$output = $crud->render();
		$data = (array)$output;
		$data['titulo'] = 'Dispositivos';
		$this->load->view('dispositivos/index', $data);
	}

	public function add_log_create($post_array){
		$this->addLog('Dispositivos', 'Crear', json_encode($post_array));
		return $post_array;
	}

	public function add_log_edit($post_array){
		$this->addLog('Dispositivos', 'Editar', json_encode($post_array));
		return $post_array;
	}

	public function add_log_delete($primary_key){
		$this->db->where('id',$primary_key);
    	$entity_row = $this->db->get('dispositivos')->row();
		$this->addLog('Dispositivos', 'Eliminar', json_encode($entity_row));
		return true;
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