<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario_model extends CI_Model {

    public function verificar_usuario($correo, $contraseña) {
        $this->db->where('correo', $correo);
        $this->db->where('contraseña', $contraseña); // 🔐 Mejora esto con password_hash en producción
        $query = $this->db->get('usuarios');

        return $query->row(); // Devuelve objeto si encuentra
    }

    public function insertar($data) {
        return $this->db->insert('usuarios', $data);
    }
}
