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

		$fecha_desde = $capturas_consolidadas[0]['fecha_hora'];
		$fecha_hasta = $capturas_consolidadas[count($capturas_consolidadas) - 1]['fecha_hora'];
		
		$date = date('d-m-Y');
		$time = date('H:i:s');
		$time2 = date('H:i');

		$this->load->library('fpdf/fpdf.php');
		$img = '';

		$pdf = new Fpdf();
		$pdf->AddPage('L', 'A4', 0);
		$pdf->SetAutoPageBreak(true, 20);

		//cabecera principal
		// Logo
		$pdf->Image(base_url().'assets/img/logo.png',10,6,30);
		$this->Header($pdf);
		$pdf->Ln(20);
		$pdf->Cell(50, 10, 'Período: '.$fecha_desde.' - '.$fecha_hasta, 30, 1);
		$pdf->Ln();
		$this->SubHeader($pdf, $org);
		$pdf->Ln(5);
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
				$pdf->Cell(100, 100, $pdf->Image(base_url().'assets/imagenes_capturadas/'.$cc['imagen'], $pdf->GetX(), $pdf->GetY(),80, 80),1,0,'');
				$pdf->Cell(40, 100, utf8_decode($cc['ubicacion']), 1, 0, '');
				$pdf->Cell(40, 100, $cc['canal'], 1, 0, '');
				$pdf->Cell(40, 100, utf8_decode($cc['observacion']), 1, 0, '');
				$pdf->Cell(40, 100, $cc['fecha_hora'], 1, 0, '');
				$pdf->Ln();
			}
		}
		$pdf->Output();	
	}

	public function Header($pdf){  
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
		$pdf->SetX(-255);
		//Display Company Info
		$pdf->SetFont('Arial','B',14);
		$pdf->Cell(50,10, utf8_decode($nombre_empresa),30,1);
		$pdf->SetFont('Arial','',14);
		$pdf->SetX(-255);
		$pdf->Cell(50,7,utf8_decode($direccion_empresa),30,1);
		$pdf->SetX(-255);
		$pdf->Cell(50,7,utf8_decode($email_empresa),30,1);
		$pdf->SetX(-255);
		$pdf->Cell(50,7,utf8_decode($telefono_empresa),30,1);
		
		//Display INVOICE text
		$pdf->SetY(15);
		$pdf->SetX(-80);
		$pdf->SetFont('Arial','B',18);
		$pdf->Cell(50,10,"INFORME",30,1);
		
		//Display Horizontal line
		//$pdf->Line(0,48,210,48);
	}

	public function SubHeader($pdf, $organizacion_id){  
		$this->db->select('*');
		$this->db->from('organizaciones');
		$this->db->where('id', $organizacion_id);
		$this->db->limit(1);
		$organizacion = $this->db->get()->result_array();

		$pdf->SetFont('Times', 'B', 10);
		$pdf->Cell(100, 10, 'Rut: ', 1, 0, 'C');
		$pdf->Cell(40, 10, (!empty($organizacion[0]['rut']) ? $organizacion[0]['rut'] : 'N/A'), 1, 0, 'C');
		$pdf->Cell(40, 10, 'Contacto: ', 1, 0, 'C');
		$pdf->Cell(40, 10, utf8_decode((!empty($organizacion[0]['contacto']) ? $organizacion[0]['contacto'] : 'N/A')), 1, 0, 'C');
		$pdf->Ln();

		$pdf->SetFont('Times', 'B', 10);

		$pdf->Cell(40, 10, utf8_decode('Razón Social: '), 1, 0, 'C');
		$pdf->Cell(40, 10, utf8_decode((!empty($organizacion[0]['razon_social']) ? $organizacion[0]['razon_social'] : 'N/A')), 1, 0, 'C');

		$pdf->Cell(100, 10, utf8_decode('Dirección: '), 1, 0, 'C');
		$pdf->Cell(40, 10, utf8_decode((!empty($organizacion[0]['direccion']) ? $organizacion[0]['direccion'] : 'N/A')), 1, 0, 'C');
		
		$pdf->Ln();

		$pdf->SetFont('Times', 'B', 10);
		$pdf->Cell(100, 10, utf8_decode('Teléfono Contacto: '), 1, 0, 'C');
		$pdf->Cell(40, 10, (!empty($organizacion[0]['telefono']) ? $organizacion[0]['telefono'] : 'N/A'), 1, 0, 'C');
		$pdf->Ln();
	}
	  
	public function body($info,$products_info){
		
		//Billing Details
		$this->SetY(55);
		$this->SetX(10);
		$this->SetFont('Arial','B',12);
		$this->Cell(50,10,"Bill To: ",0,1);
		$this->SetFont('Arial','',12);
		$this->Cell(50,7,$info["customer"],0,1);
		$this->Cell(50,7,$info["address"],0,1);
		$this->Cell(50,7,$info["city"],0,1);
		
		//Display Invoice no
		$this->SetY(55);
		$this->SetX(-60);
		$this->Cell(50,7,"Invoice No : ".$info["invoice_no"]);
		
		//Display Invoice date
		$this->SetY(63);
		$this->SetX(-60);
		$this->Cell(50,7,"Invoice Date : ".$info["invoice_date"]);
		
		//Display Table headings
		$this->SetY(95);
		$this->SetX(10);
		$this->SetFont('Arial','B',12);
		$this->Cell(80,9,"DESCRIPTION",1,0);
		$this->Cell(40,9,"PRICE",1,0,"C");
		$this->Cell(30,9,"QTY",1,0,"C");
		$this->Cell(40,9,"TOTAL",1,1,"C");
		$this->SetFont('Arial','',12);
		
		//Display table product rows
		foreach($products_info as $row){
		  $this->Cell(80,9,$row["name"],"LR",0);
		  $this->Cell(40,9,$row["price"],"R",0,"R");
		  $this->Cell(30,9,$row["qty"],"R",0,"C");
		  $this->Cell(40,9,$row["total"],"R",1,"R");
		}
		//Display table empty rows
		for($i=0;$i<12-count($products_info);$i++)
		{
		  $this->Cell(80,9,"","LR",0);
		  $this->Cell(40,9,"","R",0,"R");
		  $this->Cell(30,9,"","R",0,"C");
		  $this->Cell(40,9,"","R",1,"R");
		}
		//Display table total row
		$this->SetFont('Arial','B',12);
		$this->Cell(150,9,"TOTAL",1,0,"R");
		$this->Cell(40,9,$info["total_amt"],1,1,"R");
		
		//Display amount in words
		$this->SetY(225);
		$this->SetX(10);
		$this->SetFont('Arial','B',12);
		$this->Cell(0,9,"Amount in Words ",0,1);
		$this->SetFont('Arial','',12);
		$this->Cell(0,9,$info["words"],0,1);
		
	}

	public function Footer(){
		
		//set footer position
		$this->SetY(-50);
		$this->SetFont('Arial','B',12);
		$this->Cell(0,10,"for ABC COMPUTERS",0,1,"R");
		$this->Ln(15);
		$this->SetFont('Arial','',12);
		$this->Cell(0,10,"Authorized Signature",0,1,"R");
		$this->SetFont('Arial','',10);
		
		//Display Footer Text
		$this->Cell(0,10,"This is a computer generated invoice",0,1,"C");
		
	}
}
