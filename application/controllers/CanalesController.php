<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CanalesController extends CI_Controller {

    function __construct()
	{
		parent::__construct();
		ini_set('date.timezone', 'America/Santiago');
		$this->load->model('Canales', 'modelo');
	}

	public function index()
	{
        $organizaciones = $this->db->get('organizaciones')->result_array();
		$data = [
			'titulo' => 'Canales',
			'organizaciones' => $organizaciones
		];
		$this->load->view('canales/index', $data);
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

    public function obtenerCantidadCanalesDispotivo(){
		$dispositivo = $this->input->post('dispositivo');
		$this->db->select('cantidad_canales');
		$this->db->from('dispositivos');
		$this->db->where('id', $dispositivo);
		$this->db->limit(1);
		$canales = $this->db->get()->result_array();
		$cantidad_canales = !empty($canales[0]['cantidad_canales']) ? $canales[0]['cantidad_canales'] : 0;

        $this->db->select('*');
        $this->db->from('canales');
        $this->db->where('devices_id', $dispositivo);
        $this->db->order_by('canal ASC');
        $canales = $this->db->get()->result_array();
        $tbody = '';
        if(!empty($canales)){
            for($i=0; $i< count($canales); $i++){
                $tbody .= '<tr>';
                $tbody .= '<td>'.$canales[$i]['canal'].'</td>';
                $tbody .= '<td><input class="form-control" name="canales" id="input-canal-'.$canales[$i]['canal'].'" value="'.$canales[$i]['nombre'].'" /></td>';
                $tbody .= '</tr>';
            }
        }
        else{
            for($i=1; $i<= $cantidad_canales; $i++){
                $tbody .= '<tr>';
                $tbody .= '<td>'.$i.'</td>';
                $tbody .= '<td><input class="form-control" name="canales" id="input-canal-'.$i.'" value="Canal '.$i.'" /></td>';
                $tbody .= '</tr>';
            }
        }
        echo $tbody;
	}

    public function addCanales(){
        $dispositivo = $this->input->post('dispositivo');
        $canales = $this->input->post('canales');

        $this->db->where('devices_id', $dispositivo);
        $this->db->delete('canales');

        foreach($canales as $c){
            $data_canales = [
                                'devices_id' => $dispositivo,
                                'canal' => $c['canal'],
                                'nombre' => $c['nombre']
                            ];
            $this->db->insert('canales', $data_canales);
        }
    }

}
