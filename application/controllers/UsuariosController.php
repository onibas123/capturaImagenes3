<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UsuariosController extends CI_Controller {

    function __construct()
	{
		parent::__construct();
		ini_set('date.timezone', 'America/Santiago');
		$this->load->model('Usuarios', 'modelo');
	}

	public function index()
	{
		$this->load->library('grocery_CRUD');
		$crud = new grocery_CRUD();
		$crud->set_table('usuarios');
		$crud->set_subject('Usuario');
		$crud->set_language('spanish');
		
		$crud->set_relation('roles_id','roles','nombre');
		$crud->display_as('roles_id','Rol');

		$crud->field_type('password', 'password');
		$crud->field_type('email', 'email');
		
		$crud->unset_columns(array('password'));
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
		$crud->callback_before_insert(array($this,'encrypt_password_and_insert_callback'));
		$crud->callback_before_update(array($this,'encrypt_password_and_update_callback'));

		$crud->required_fields('usuario','password', 'nombre', 'roles_id');

		$output = $crud->render();
		$data = (array)$output;
		$data['titulo'] = 'Usuarios';
		$this->load->view('usuarios/index', $data);
	}

	function encrypt_password_and_insert_callback($post_array) {
		$post_array['password'] = md5($post_array['password']);
		return $post_array;
	} 

	function encrypt_password_and_update_callback($post_array) {
		$email = $post_array['email'];
		$this->db->select('password');
		$this->db->from('usuarios');
		$this->db->where('email', $email);
		$this->db->limit(1);
		$res = $this->db->get()->result_array();

		$input_password = $post_array['password'];
		if($input_password != $res[0]['password'])
			$post_array['password'] = md5($post_array['password']);
		return $post_array;
	} 

    public function login(){
		$usuario = trim($this->input->post('usuario', TRUE));
		$password = trim($this->input->post('password', TRUE));
        
		$usuarioValidado = $this->modelo->login($usuario, md5($password));
		if(!empty($usuarioValidado)){
			if(!empty($usuarioValidado[0]['estado']) && $usuarioValidado[0]['estado'] == 1){
				//get options by rol
				$this->db->select('opciones.id, opciones.nombre, nivel, orden, padre, controlador, accion, icono');
				$this->db->from('opciones');
				$this->db->join('opcion_rol', 'opcion_rol.opciones_id = opciones.id');
				$this->db->where('opcion_rol.roles_id', $usuarioValidado[0]['roles_id']);
				$this->db->order_by('padre ASC, orden ASC');
				$opciones = $this->db->get()->result_array();

				$session_array = array(
					'usuario_id' => $usuarioValidado[0]['id'],
					'usuario_usuario' => $usuarioValidado[0]['email'],
					'usuario_password_raw' => $password,
					'usuario_password' => $usuarioValidado[0]['password'],
					'usuario_nombre' => $usuarioValidado[0]['nombre'],
					'usuario_email' => $usuarioValidado[0]['email'],
					'usuario_guarda' => $usuarioValidado[0]['guarda'],
					'usuario_edita' => $usuarioValidado[0]['edita'],
					'usuario_elimina' => $usuarioValidado[0]['elimina'],
					'roles_id' => $usuarioValidado[0]['roles_id'],
					'roles_nombre' => $usuarioValidado[0]['roles_nombre'],
					'opciones' => $opciones
				);
				$this->session->set_userdata($session_array);
				header('Location: '.base_url().'index.php/UsuariosController/mi_cuenta');
			}
			else{
				$data = ['mensaje' => '<font color="red">Usuario Deshabilitado, por favor consulta a Administración.</font>'];
				$this->load->view('login',$data);
			}
		}
		else{
			$data = ['mensaje' => '<font color="red">Usuario y/o Contraseña incorrecta.</font>'];
			$this->load->view('login',$data);
		}
	}

	public function logout()
	{
		$this->session->userdata = array();
		$this->session->sess_destroy();
		header('Location: ' . base_url());
	}

	public function mi_cuenta(){
		$usuario_id = 1; //reemplazar por id de sesion
		$usuario = $this->modelo->obtener_usuario_id($usuario_id);
		$data = 	[
						'usuario' => $usuario
					];
		$this->load->view('usuarios/mi_cuenta', $data);
	}

	public function actualizarMisDatos(){
		$nombre = trim($this->input->post('nombre', TRUE));
		$email = trim($this->input->post('email', TRUE));
		$password = trim($this->input->post('password', TRUE));

		$usuario_id = 1; //reemplazar por id de sesion
		
		$this->db->where('id', $usuario_id);
		$usuario = $this->db->get('usuarios')->result_array();
		$datos['nombre'] = $nombre;
		$datos['email'] = $email;
		if($password == $usuario[0]['password'])
			$datos['email'] = $email;

		if($this->db->update('usuarios', $datos, array('id' => $usuario_id))){
			$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
				<strong>Datos Actualizados de manera correcta</strong>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>');
		}
		else{
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
				<strong>Ha ocurrido un problema con la actualización de los datos</strong>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>');
		}
		header('Location: ' . base_url().'index.php/UsuariosController/mi_cuenta');
	}
}
