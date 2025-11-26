<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Usuario_model');
        $this->load->library('session');
    }

    public function index() {
        $this->load->view('login');
    }

    public function login() {
        $correo = $this->input->post('correo');
        $contraseña = $this->input->post('contraseña');

        // Verificar usuario y contraseña (debe validar hash si usas)
        $usuario = $this->Usuario_model->verificar_usuario($correo, $contraseña);

        if ($usuario) {
            $this->session->set_userdata([
                'id_usuario' => $usuario->id_usuario,
                'nombre'     => $usuario->nombre,
                'rol'        => $usuario->rol,
                'logueado'   => TRUE
            ]);

            // Redirección según el rol
            if ($usuario->rol == 'admin') {
                redirect('tickets/index'); // Ajusta la ruta para admin
            } elseif ($usuario->rol == 'cliente') {
                redirect('tickets/nuevo'); // Ruta para clientes
            } else {
                // Por seguridad, cerrar sesión si rol no reconocido
                redirect('auth/logout');
            }

        } else {
            $this->session->set_flashdata('error', 'Correo o contraseña incorrectos.');
            redirect('auth');
        }
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('auth');
    }
}
