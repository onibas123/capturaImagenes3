<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class InformesController extends CI_Controller {

    function __construct()
	{
		parent::__construct();
		ini_set('date.timezone', 'America/Santiago');
	}

	public function index()
	{
		$this->load->library('grocery_CRUD');
		$crud = new grocery_CRUD();
		$crud->set_table('informes');
		$crud->set_subject('Informes');
		$crud->set_language('spanish');

		$crud->unset_print();
		$crud->unset_export();
		$crud->unset_clone();
		$crud->unset_add();
		$crud->unset_edit();
		$crud->unset_delete();
		$crud->unset_columns(['observacion', 'ruta_imagen']);

		$crud->set_relation('organizaciones_id','organizaciones','nombre');

		$crud->callback_before_insert(array($this,'add_log_create'));
		$crud->callback_before_update(array($this,'add_log_edit'));
		$crud->callback_before_delete(array($this,'add_log_delete'));

        $crud->display_as('ruta', 'Enlace');
        $crud->callback_column('ruta', function ($value, $row) {
            $enlace = '<a href="' . $row->ruta . '" download="reporte_'.date('YmdHis').'">Enlace</a>';
            
            return $enlace;
        });

		$crud->add_action('Reenviar Correo', base_url().'assets/img/email.png', 'InformesController/reenviarCorreo', '','', array($this,'get_row_id' ));
		$crud->order_by('fecha','desc');

		$output = $crud->render();
		$data = (array)$output;
		$data['titulo'] = 'Listado Informes';
		$this->load->view('informes/index', $data);
	}

    public function add_log_create($post_array){
		$this->addLog('Informes', 'Crear', json_encode($post_array));
		return $post_array;
	}

	public function add_log_edit($post_array){
		$this->addLog('Informes', 'Editar', json_encode($post_array));
		return $post_array;
	}

	public function add_log_delete($primary_key){
		$this->db->where('id',$primary_key);
    	$entity_row = $this->db->get('capturas')->row();
		$this->addLog('Informes', 'Eliminar', json_encode($entity_row));
		return true;
	}

	public function reenviarCorreo($id){
		$informe_id = $id;
		$this->db->select('organizaciones_id, ruta, fecha');
		$this->db->from('informes');
		$this->db->where('id', $informe_id);
		$this->db->limit(1);
		$res = $this->db->get()->result_array();

		$fecha = date('d-m-Y H:i', strtotime($res[0]['fecha']));
		$ruta = str_replace('https://sistemaspccurico.cl/sgmas/','.', $res[0]['ruta']);
		$organizacion = $res[0]['organizaciones_id'];
		
		$this->db->select('nombre, email');
		$this->db->from('organizaciones');
		$this->db->where('id', $organizacion);
		$this->db->limit(1);
		$res = $this->db->get()->result_array();
		if(!empty($res)){
			$asunto = 'Informe '.( !empty($res[0]['nombre']) ?  $res[0]['nombre'] : 'N/A' ).' '.date('d/m/Y');
			$destino = ( !empty($res[0]['email']) ?  $res[0]['email'] : 'jcares@pccurico.cl' );
			$adjunto = $ruta;

			$this->db->select('contacto');
			$this->db->from('organizaciones_contactos');
			$this->db->where('estado', 1);
			$this->db->where('organizaciones_id', $organizacion);
			$copia = $this->db->get()->result_array();
			$mensaje = 'Estimado, se adjunta reenvia informe con detalle de observaciones de la zona con fecha de creación '.$fecha;

			$arr_copia = [];

			foreach($copia as $c)
				$arr_copia[] = $c['contacto'];

			$this->enviar_correo($destino, $asunto, $mensaje, $arr_copia, $adjunto);
		}

		echo 'Informe reenviado<br>';
		echo '<a href="'.base_url().'index.php/InformesController/index">Volver</a>';
	}

	//----------------------------------------------------------------------
	public function enviar_correo($destino, $asunto, $mensaje, $copia = null, $adjunto = null) {
		ini_set('memory_limit', -1);

		$this->db->select('valor');
        $this->db->from('configuraciones');
        $this->db->where('parametro', 'smtp_user_sender');
        $this->db->limit(1);
        $smtp_user_sender = $this->db->get()->result_array();
        $smtp_user_sender = $smtp_user_sender[0]['valor'];

        $this->db->select('valor');
        $this->db->from('configuraciones');
        $this->db->where('parametro', 'smtp_pass');
        $this->db->limit(1);
        $smtp_pass = $this->db->get()->result_array();
        $smtp_pass = $smtp_pass[0]['valor'];

        $this->db->select('valor');
        $this->db->from('configuraciones');
        $this->db->where('parametro', 'smtp_host_sender');
        $this->db->limit(1);
        $smtp_host_sender = $this->db->get()->result_array();
        $smtp_host_sender = $smtp_host_sender[0]['valor'];

        $this->db->select('valor');
        $this->db->from('configuraciones');
        $this->db->where('parametro', 'smtp_port_sender');
        $this->db->limit(1);
        $smtp_port_sender = $this->db->get()->result_array();
        $smtp_port_sender = $smtp_port_sender[0]['valor'];

        $this->db->select('valor');
        $this->db->from('configuraciones');
        $this->db->where('parametro', 'smtp_crypto');
        $this->db->limit(1);
        $smtp_crypto = $this->db->get()->result_array();
        $smtp_crypto = $smtp_crypto[0]['valor'];

        $this->load->library('phpmailer_lib');

        if ($this->phpmailer_lib->enviar_correo($smtp_user_sender, $smtp_pass, $smtp_host_sender, $smtp_port_sender, $smtp_crypto, $destino, $asunto, $mensaje, $adjunto, $copia)) {
            echo 'El correo se envió correctamente.';
        } else {
            echo 'Error al enviar el correo.';
        }
    }

}
