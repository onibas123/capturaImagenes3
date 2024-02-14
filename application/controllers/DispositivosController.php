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
		$crud->unset_add();
		$crud->unset_edit();
			
		if($this->session->userdata('usuario_edita') == 1)
			$crud->add_action('action1', base_url().'assets/grocery_crud/themes/flexigrid/css/images/edit.png', 'DispositivosController/edit', '','', array($this,'get_row_id' ));
			
		if($this->session->userdata('usuario_elimina') == 0)
			$crud->unset_delete();

		$crud->callback_before_insert(array($this,'add_log_create'));
		$crud->callback_before_update(array($this,'add_log_edit'));
		$crud->callback_before_delete(array($this,'add_log_delete'));
		
		$output = $crud->render();
		$data = (array)$output;
		$data['titulo'] = 'Ubicaciones';
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

	public function add(){
		$organizaciones = $this->db->get('organizaciones')->result_array();
		$tipo_dispositivo = $this->db->get('tipo_dispositivo')->result_array();
		$marcas = $this->db->get('marcas')->result_array();
		$data = [
			'titulo' => 'Agregar Ubicación',
			'tipo_dispositivo' => $tipo_dispositivo,
			'marcas' => $marcas,
			'organizaciones' => $organizaciones
		];
		$this->load->view('dispositivos/add', $data);
	}

	public function addOrganizacion(){
		$rut = $this->input->post('rut', true);
		$tipo_organizacion = $this->input->post('tipo_organizacion', true);
		$nombre = $this->input->post('nombre', true);
		$direccion = $this->input->post('direccion', true);
		$telefono = $this->input->post('telefono', true);
		$email = $this->input->post('email', true);
		$contacto = $this->input->post('contacto', true);
		$cantidad_dispositivos = $this->input->post('cantidad_dispositivos', true);

		$data_organizacion = 	[
									'nombre' => $nombre,
									'cantidad_dispositivos' => $cantidad_dispositivos,
									'rut' => $rut,
									'creado' => date('Y-m-d H:i:s'),
									'direccion' => $direccion,
									'contacto' => $contacto,
									'telefono' => $telefono,
									'email' => $email,
									'tipo_organizacion_id' => $tipo_organizacion
								];

		$this->db->insert('organizaciones', $data_organizacion);
		$last_id = $this->db->insert_id();
		if($last_id > 0){
			$emails_contactos = $this->input->post('emails_contactos');
			if(count($emails_contactos) > 0){
				$this->db->where('organizaciones_id', $last_id);
				$this->db->delete('organizaciones_contactos');
				foreach($emails_contactos as $ec){
					$arr_temp = ['organizaciones_id' => $last_id, 'contacto' => $ec];
					$this->db->insert('organizaciones_contactos', $arr_temp);
				}
			}
		}

		echo 'Se ha agregado de manera correcta.';
	}

	public function edit($id){
		$this->db->select('*');
		$this->db->from('organizaciones');
		$this->db->where('id', $id);
		$this->db->limit(1);
		$organizacion = $this->db->get()->result_array();
		
		$this->db->select('contacto');
		$this->db->from('organizaciones_contactos');
		$this->db->where('organizaciones_id', $id);
		$contactos = $this->db->get()->result_array();
		
		$tipo_organizacion = $this->db->get('tipo_organizacion')->result_array();
		$data = [
			'id' => $id,
			'titulo' => 'Editar Dispositivo #'.$id,
			'tipo_organizacion' => $tipo_organizacion,
			'organizacion' => $organizacion,
			'contactos' => $contactos
		];
		$this->load->view('dispositivos/edit', $data);
	}

	public function addDispositivo(){
		/*
		organizacion: organizacion, nombre: nombre,
		tipo: tipo, marca: marca,
		cantidad_canales: cantidad_canales, ubicacion: ubicacion,
		codificar: codificar, estado: estado,
		ip: ip, puerto: puerto,
		usuario: usuario, password: password,
		datos_extras: datos_extras,
		canales: canales_arr
		*/
		$organizacion = $this->input->post('organizacion', true);
		$nombre = $this->input->post('nombre', true);
		$tipo = $this->input->post('tipo', true);
		$marca = $this->input->post('marca', true);
		$cantidad_canales = $this->input->post('cantidad_canales', true);
		$ubicacion = $this->input->post('ubicacion', true);
		$codificar = $this->input->post('codificar', true);
		$estado = $this->input->post('estado', true);
		$ip = $this->input->post('ip', true);
		$puerto = $this->input->post('puerto', true);
		$usuario = $this->input->post('usuario', true);
		$password = $this->input->post('password', true);
		$datos_extras = $this->input->post('datos_extras', true);
		$canales = $this->input->post('canales');
		print_r($_POST);
	}

}