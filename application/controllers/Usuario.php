<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Usuario_model');
        $this->load->helper('url');
        $this->load->library('session');
    }

    public function index() {
        $this->load->view('usuario_form');
    }

        public function guardar() {
        $data = [
            'nombre'     => $this->input->post('nombre'),
            'correo'     => $this->input->post('correo'),
            'contraseña' => $this->input->post('contraseña'), 
            'rol'        => $this->input->post('rol')
        ];

        $this->Usuario_model->insertar($data);
        $this->session->set_flashdata('msg', 'Usuario registrado correctamente.');
        redirect('usuario');
    }


}
