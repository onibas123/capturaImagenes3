<?php
class LogsController extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('Logs', 'modelo');
	}
	
	public function index()
	{
		$this->load->library('grocery_CRUD');
		$crud = new grocery_CRUD();
		$crud->set_table('logs');
		$crud->set_subject('Log');
		$crud->set_language('spanish');

		$crud->unset_clone();
		$crud->unset_add();
		$crud->unset_edit();
		$crud->unset_delete();

		$crud->set_relation('usuarios_id','usuarios','nombre');
		$crud->display_as('usuarios_id','Usuario');

		$output = $crud->render();
		$data = (array)$output;
		$data['titulo'] = 'Logs';
		$this->load->view('logs/index', $data);
	}
}