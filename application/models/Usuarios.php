<?php
class Usuarios extends CI_Model {
    
    public function __construct()
    {
        parent::__construct();
    }
    
    public function obtener_usuario_id($id){
        $this->db->select('u.id, u.roles_id, u.email, u.password, u.nombre, u.guarda, u.edita, u.elimina, r.nombre as rol');
        $this->db->from('usuarios u');
        $this->db->join('roles r', 'r.id = u.roles_id');
        $this->db->where('u.id', $id);
        return $this->db->get()->result_array();
    }
}