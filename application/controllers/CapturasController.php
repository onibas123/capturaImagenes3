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
		/*
        if($this->session->userdata('usuario_escribir') == 0)
			$crud->unset_add();
		if($this->session->userdata('usuario_editar') == 0)
			$crud->unset_edit();
		if($this->session->userdata('usuario_eliminar') == 0)
			$crud->unset_delete();
		*/

		$output = $crud->render();
		$data = (array)$output;
		$data['titulo'] = 'Capturas Histórico';
		$this->load->view('capturas/index', $data);
		/*
		$roles = $this->modelo->getRoles();
		$data = [
					'titulo' => 'Roles',
					'roles' => $roles
				];
		$this->load->view('roles/index', $data);
		*/
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
		if($this->db->insert('capturas', $data_captura))
			echo 1;
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

		$this->db->select('*');
		$this->db->from('configuraciones');
		$configuraciones = $this->db->get()->result_array();

		$nombre_empresa = '';
		$direccion_empresa = '';
		$email_empresa = '';
		$telefono_empresa = '';

		foreach($configuraciones as $c){
			$nombre_empresa = $c['nombre_empresa'];
			$direccion_empresa = $c['direccion_empresa'];
			$email_empresa = $c['email_empresa'];
			$telefono_empresa = $c['telefono_empresa'];
		}

		$date = date('d-m-Y');
		$time = date('H:i:s');
		$time2 = date('H:i');

		$this->load->library('fpdf/fpdf.php');
		$img = '';

		$pdf = new Fpdf();
		$pdf->AddPage('L', 'A4', 0);
		$pdf->SetAutoPageBreak(true, 20);
		//$y = $pdf->GetY();

		$pdf->SetFont('Times', '', 10);
		$pdf->Cell(276, 10, 'Informe '.$date, 0, 0, 'C');
		$pdf->Ln(20);
		//cabecera principal
		$pdf->Image(base_url().'assets/img/logo.png', 130 ,5, 70 , 25,'');
		$pdf->Cell(40, 10, utf8_decode($nombre_empresa), 1, 0, 'C');
		$pdf->Cell(40, 10, utf8_decode($direccion_empresa), 1, 0, 'C');
		$pdf->Cell(40, 10, utf8_decode($email_empresa), 1, 0, 'C');
		$pdf->Cell(40, 10, utf8_decode($nombre_empresa), 1, 0, 'C');
		//tabla
		//cabecera
		$pdf->SetFont('Times', 'B', 10);
		$pdf->Cell(100, 10, 'Imagen', 1, 0, 'C');
		$pdf->Cell(40, 10, utf8_decode('Ubicación'), 1, 0, 'C');
		$pdf->Cell(40, 10, utf8_decode('Cámara'), 1, 0, 'C');
		$pdf->Cell(40, 10, utf8_decode('Observación'), 1, 0, 'C');
		$pdf->Cell(40, 10, 'Fecha', 1, 0, 'C');
		$pdf->Ln();
		//cuerpo
		if(!empty($capturas_consolidadas)){
			foreach($capturas_consolidadas as $cc){
				$pdf->SetFont('Times', '', 10);	
				$pdf->Cell(100, 10, 1, 1, 0, 'C');
				$pdf->Image(base_url().'assets/imagenes_capturadas/'.$cc['imagen'], 130 ,5, 70 , 25,'');
				$pdf->Cell(40, 10, utf8_decode($cc['ubicacion']), 1, 0, 'C');
				$pdf->Cell(40, 10, $cc['canal'], 1, 0, 'C');
				$pdf->Cell(40, 10, utf8_decode($cc['observacion']), 1, 0, 'C');
				$pdf->Cell(40, 10, $cc['fecha_hora'], 1, 0, 'C');
				$pdf->Ln();
			}
		}
		$pdf->Output();	
	}
}
