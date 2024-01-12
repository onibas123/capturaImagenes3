<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CapturasController extends CI_Controller {

    function __construct()
	{
		parent::__construct();
		ini_set('date.timezone', 'America/Santiago');
		$this->load->model('Capturas', 'modelo');
	}

	public function index()
	{
		$this->load->library('grocery_CRUD');
		$crud = new grocery_CRUD();
		$crud->set_table('capturas');
		$crud->set_subject('Captura');
		$crud->set_language('spanish');

		$crud->unset_print();
		$crud->unset_export();
		$crud->unset_clone();
		$crud->unset_add();
		$crud->unset_edit();
		$crud->unset_delete();
		$crud->unset_columns(['observacion', 'ruta_imagen']);

		$crud->set_relation('organizaciones_id','organizaciones','nombre');
        $crud->set_relation('dispositivos_id','dispositivos','nombre');
		$crud->set_relation('usuario_id','usuarios','nombre');

		$crud->callback_before_insert(array($this,'add_log_create'));
		$crud->callback_before_update(array($this,'add_log_edit'));
		$crud->callback_before_delete(array($this,'add_log_delete'));

		$crud->display_as('organizaciones_id','Organización')->display_as('dispositivos_id','Dispositivo')
		->display_as('usuario_id','Usuario');
		$crud->field_type('password', 'password');

		$output = $crud->render();
		$data = (array)$output;
		$data['titulo'] = 'Capturas Histórico';
		$this->load->view('capturas/index', $data);
	}

	public function add_log_create($post_array){
		$this->addLog('Capturas', 'Crear', json_encode($post_array));
		return $post_array;
	}

	public function add_log_edit($post_array){
		$this->addLog('Capturas', 'Editar', json_encode($post_array));
		return $post_array;
	}

	public function add_log_delete($primary_key){
		$this->db->where('id',$primary_key);
    	$entity_row = $this->db->get('capturas')->row();
		$this->addLog('Capturas', 'Eliminar', json_encode($entity_row));
		return true;
	}

    public function add(){
		$organizaciones = $this->db->get('organizaciones')->result_array();
		$data = [
			'titulo' => 'Captura Simple',
			'organizaciones' => $organizaciones
		];
		$this->load->view('capturas/add', $data);
	}

	public function schema(){
		$organizaciones = $this->db->get('organizaciones')->result_array();
		$data = [
			'titulo' => 'Esquema de Horarios',
			'organizaciones' => $organizaciones
		];
		$this->load->view('capturas/schema', $data);
	}

	public function consolidate(){
		$organizaciones = $this->db->get('organizaciones')->result_array();
		$data = [
			'titulo' => 'Consolidar',
			'organizaciones' => $organizaciones
		];
		$this->load->view('capturas/consolidate', $data);
	}

	public function report(){
		$organizaciones = $this->db->get('organizaciones')->result_array();
		$data = [
			'titulo' => 'Reporte',
			'organizaciones' => $organizaciones
		];
		$this->load->view('capturas/report', $data);
	}

	public function obtenerDispositivosOrganizacion(){
		$organizacion = $this->input->post('organizacion');
		$this->db->where('organizaciones_id', $organizacion);
		$dispositivos = $this->db->get('dispositivos')->result_array();
		echo json_encode($dispositivos);
	}

	public function obtenerCantidadCanalesDispotivo(){
		$dispositivo = $this->input->post('dispositivo');
		$this->db->select('cantidad_canales');
		$this->db->from('dispositivos');
		$this->db->where('id', $dispositivo);
		$this->db->limit(1);
		$canales = $this->db->get()->result_array();
		echo !empty($canales[0]['cantidad_canales']) ? $canales[0]['cantidad_canales'] : 0;
	}

	public function guardarSchema(){
		$organizacion = $this->input->post('organizacion', true);
		$dispositivo = $this->input->post('dispositivo', true);
		$schema = $this->input->post('schema');

		$this->db->where('dispositivos_id', $dispositivo);
		$this->db->delete('esquemas');

		$data_schema = [];
		foreach($schema as $s){
			foreach($s['horas'] as $h){
				$data_schema = 	[
					'dispositivos_id' => $dispositivo,
					'Lun' => ($s['lun'] == 'true') ? 1 : 0,
					'Mar' => ($s['mar'] == 'true') ? 1 : 0,
					'Mie' => ($s['mie'] == 'true') ? 1 : 0,
					'Jue' => ($s['jue'] == 'true') ? 1 : 0,
					'Vie' => ($s['vie'] == 'true') ? 1 : 0,
					'Sab' => ($s['sab'] == 'true') ? 1 : 0,
					'Dom' => ($s['dom'] == 'true') ? 1 : 0,
					'hora' => $h,
					'canal' => $s['canal']
				];
				$this->db->insert('esquemas', $data_schema);
			}
		}

		$data_log = ['dispositivo' => $dispositivo, 'esquema' => $schema];
		$this->addLog('Capturas', 'Crear Esquema Horarios', json_encode($data_log));
		echo 1;
	}

	public function obtenerSchema(){
		$dispositivo = $this->input->post('dispositivo', true);
		$this->db->select('*');
		$this->db->from('esquemas');
		$this->db->where('dispositivos_id', $dispositivo);
		$this->db->order_by('canal ASC, hora ASC');
		$response = $this->db->get()->result_array();
		echo json_encode($response);
	}

	public function addCaptura(){
		$organizacion = $this->input->post('organizacion', true);
		$dispositivo = $this->input->post('dispositivo', true);
		$canal = $this->input->post('canal', true);
		$date_time = date('Y-m-d H:i:s');
		$ruta_imagen = '';
		$observacion = $this->input->post('observacion', true);
		$usuario_id = 1; //cambiar por usuario de sesion o sistema
		$consolidado = $this->input->post('consolidado', true);

		$data_captura = 	[
								'organizaciones_id' => $organizacion,
								'dispositivos_id' => $dispositivo,
								'canal' => $canal,
								'fecha_hora' => $date_time,
								'ruta_imagen' => $ruta_imagen,
								'observacion' => $observacion,
								'usuario_id' => $usuario_id,
								'consolidado' => $consolidado
							];
		if($this->db->insert('capturas', $data_captura)){
			$this->addLog('Capturas', 'Crear', json_encode($data_captura));
			echo 1;
		}
		else
			echo 0;
	}

	public function obtenerCapturasConsolidar(){
		$dispositivo = $this->input->post('dispositivo', true);
		$desde = $this->input->post('desde', true);
		$hasta = $this->input->post('hasta', true);

		$this->db->select('*, DATE_FORMAT(fecha_hora, "%d-%m-%Y") as fecha, DATE_FORMAT(fecha_hora, "%H:%i") as hora');
		$this->db->from('capturas');
		$this->db->where('dispositivos_id', $dispositivo);
		$this->db->where('DATE(fecha_hora) >=', $desde);
		$this->db->where('DATE(fecha_hora) <=', $hasta);
		$this->db->where('consolidado', 0);
		echo json_encode($this->db->get()->result_array());
	}

	public function guardarConsolidacion(){
		$data_consolidar = $this->input->post('data_consolidar');
		foreach($data_consolidar as $dc){
			$data = 	[
							'observacion' => $dc['observacion'],
							'consolidado' => 1
						];
			$this->db->where('id', $dc['id']);
			$this->db->update('capturas', $data);
			$this->addLog('Capturas', 'Crear Consolidado', json_encode(['capturas_id' => $dc['id'], 'data' => $data]));
		}
		echo 1;
	}

	public function obtenerCapturasConsolidado(){
		$dispositivo = $this->input->post('dispositivo', true);
		$desde = $this->input->post('desde', true);
		$hasta = $this->input->post('hasta', true);

		$this->db->select('*, DATE_FORMAT(fecha_hora, "%d-%m-%Y") as fecha, DATE_FORMAT(fecha_hora, "%H:%i") as hora');
		$this->db->from('capturas');
		$this->db->where('dispositivos_id', $dispositivo);
		$this->db->where('DATE(fecha_hora) >=', $desde);
		$this->db->where('DATE(fecha_hora) <=', $hasta);
		$this->db->where('consolidado', 1);
		echo json_encode($this->db->get()->result_array());
	}

	public function cargarPDF()
	{
		ini_set('memory_limit', '-1');
		$org = $this->input->get('org', true);
		$dev = $this->input->get('dev', true);
		$desde = $this->input->get('desde', true);
		$hasta = $this->input->get('hasta', true);

		$this->db->select('capturas.ruta_imagen as imagen, dispositivos.ubicacion as ubicacion, capturas.canal as canal, capturas.observacion as observacion, DATE_FORMAT(capturas.fecha_hora, "%d-%m-%Y %H:%i") as fecha_hora ');
		$this->db->from('capturas');
		$this->db->join('dispositivos', 'dispositivos.id = capturas.dispositivos_id');
		$this->db->where('DATE(capturas.fecha_hora) >=', $desde);
		$this->db->where('DATE(capturas.fecha_hora) <=', $hasta);
		$this->db->where('capturas.consolidado', 1);
		$this->db->order_by('capturas.fecha_hora ASC');
		$capturas_consolidadas = $this->db->get()->result_array();

		$fecha_desde = $capturas_consolidadas[0]['fecha_hora'];
		$fecha_hasta = $capturas_consolidadas[count($capturas_consolidadas) - 1]['fecha_hora'];
		
		$date = date('d-m-Y');
		$time = date('H:i:s');
		$time2 = date('H:i');

		$nombre_empresa = '';
		$direccion_empresa = '';
		$email_empresa = '';
		$telefono_empresa = '';

		$this->db->select('*');
		$this->db->from('configuraciones');
		$configuraciones = $this->db->get()->result_array();

		foreach($configuraciones as $c){
			if($c['parametro'] == 'nombre_empresa')
				$nombre_empresa = $c['valor'];
			if($c['parametro'] == 'direccion_empresa')
				$direccion_empresa = $c['valor'];
			if($c['parametro'] == 'email_empresa')
				$email_empresa = $c['valor'];
			if($c['parametro'] == 'telefono_empresa')
				$telefono_empresa = $c['valor'];
		}
		$datos_empresa = 	[
									'nombre_empresa' => $nombre_empresa,
									'direccion_empresa' => $direccion_empresa,
									'email_empresa' => $email_empresa,
									'telefono_empresa' => $telefono_empresa
								];



		$this->db->select('*');
		$this->db->from('organizaciones');
		$this->db->where('id', $org);
		$this->db->limit(1);
		$datos_organizacion = $this->db->get()->result_array();

		$data = [
					'title' => 'Informe '.$fecha_desde.' - '.$fecha_hasta, 
					'datos' => $capturas_consolidadas,
					'datos_empresa' => $datos_empresa,
					'datos_organizacion' => $datos_organizacion
				];
		$html = $this->load->view('capturas/consolidado_pdf', $data, true);
		$this->load->library('M_pdf');
		$this->m_pdf->pdf->WriteHTML($html);
		$filename = "consolidados.pdf";
		$this->m_pdf->pdf->Output($filename, "I");
	}

	public function Header($pdf, $adicional){  
		$nombre_empresa = '';
		$direccion_empresa = '';
		$email_empresa = '';
		$telefono_empresa = '';

		$this->db->select('*');
		$this->db->from('configuraciones');
		$configuraciones = $this->db->get()->result_array();

		foreach($configuraciones as $c){
			if($c['parametro'] == 'nombre_empresa')
				$nombre_empresa = $c['valor'];
			if($c['parametro'] == 'direccion_empresa')
				$direccion_empresa = $c['valor'];
			if($c['parametro'] == 'email_empresa')
				$email_empresa = $c['valor'];
			if($c['parametro'] == 'telefono_empresa')
				$telefono_empresa = $c['valor'];
		}
		$pdf->SetY(5);
		$pdf->SetX(-170);
		//Display Company Info
		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(50,10, utf8_decode($nombre_empresa),30,1);
		$pdf->SetFont('Arial','',12);
		$pdf->SetX(-170);
		$pdf->Cell(50,7,utf8_decode($direccion_empresa),30,1);
		$pdf->SetX(-170);
		$pdf->Cell(50,7,utf8_decode($email_empresa),30,1);
		$pdf->SetX(-170);
		$pdf->Cell(50,7,utf8_decode($telefono_empresa),30,1);
		
		//Display INVOICE text
		$pdf->SetY(40);
		$pdf->SetX(-150);
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(50,10,"INFORME ".utf8_decode($adicional),30,1);
		
		//Display Horizontal line
		//$pdf->Line(0,48,210,48);
	}

	public function SubHeader($pdf, $organizacion_id){  
		$this->db->select('*');
		$this->db->from('organizaciones');
		$this->db->where('id', $organizacion_id);
		$this->db->limit(1);
		$organizacion = $this->db->get()->result_array();

		$pdf->Line(10,55,200,55);
		$pdf->SetFont('Times', 'B', 10);
		$pdf->Cell(40, 7, 'Rut: ', '', 0, 'L', false);
		$pdf->SetFont('Times', 'U', 9);
		$pdf->Cell(40, 7, (!empty($organizacion[0]['rut']) ? $organizacion[0]['rut'] : 'N/A'), '', 0, 'L', false);
		$pdf->SetFont('Times', 'B', 10);
		$pdf->Cell(40, 7, 'Contacto: ', '', 0, 'L', false);
		$pdf->SetFont('Times', 'U', 9);
		$pdf->Cell(40, 7, utf8_decode((!empty($organizacion[0]['contacto']) ? $organizacion[0]['contacto'] : 'N/A')), '', 0, 'L', false);

		$pdf->Ln();

		$pdf->SetFont('Times', 'B', 10);
		$pdf->Cell(40, 7, utf8_decode('Razón Social: '), '', 0, 'L', false);
		$pdf->SetFont('Times', 'U', 9);
		$pdf->Cell(120, 7, utf8_decode((!empty($organizacion[0]['razon_social']) ? $organizacion[0]['razon_social'] : 'N/A')), '', 0, 'L', false);
		
		$pdf->Ln();
		
		$pdf->SetFont('Times', 'B', 10);
		$pdf->Cell(40, 7, utf8_decode('Dirección: '), '', 0, 'L', false);
		$pdf->SetFont('Times', 'U', 9);
		$pdf->Cell(40, 7, utf8_decode((!empty($organizacion[0]['direccion']) ? $organizacion[0]['direccion'] : 'N/A')), '', 0, 'L', false);
		
		$pdf->SetFont('Times', 'B', 10);
		$pdf->Cell(40, 7, utf8_decode('Teléfono Contacto: '), '', 0, 'L', false);
		$pdf->SetFont('Times', 'U', 9);
		$pdf->Cell(40, 7, (!empty($organizacion[0]['telefono']) ? $organizacion[0]['telefono'] : 'N/A'), '', 0, 'L', false);
		
		$pdf->Line(10,76,200,76);
		$pdf->Ln();
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

	public function capturarSnapshots(){
		//TODO: obtener aquellos dispositivos/canales acorde al seteo del esquema de horarios para capturas pantalla
		$this->db->select('d.id as dispositivo_id, d.usuario as usuario, d.password as password, d.ip as ip, d.puerto as puerto,
							d.organizaciones_id as organizacion_id, e.canal as canal');
		$this->db->from('esquemas as e');
		$this->db->join('dispositivos as d', 'd.id = e.dispositivos_id');
		$this->db->where('hora', date('H:i'));
		$this->db->order_by('e.id ASC');
		$result = $this->db->get()->result_array();
		foreach($result as $r){
			//[dispositivo_id]
			//[usuario] 
			//[password] 
			//[ip] 
			//[puerto] 
			//[organizacion_id] 
			//[canal]
			//TODO: obtener snapshot acorde al tipo_dispositivo (dvr, nvr, ipc), marca (dahua, hikvision)
			
		}
	}
}
