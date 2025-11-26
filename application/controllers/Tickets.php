<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tickets extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Ticket_model');
        $this->load->helper(array('form', 'url'));
        $this->load->library('upload');
        $this->load->library('session');

        // Verificar que el usuario esté logueado
        if (!$this->session->userdata('logueado')) {
            redirect('auth');
        }
    }

    // Mostrar todos los tickets (solo para soporte)
    public function index() {
        if ($this->session->userdata('rol') !== 'admin') {
            show_error('No tienes permiso para acceder a esta página.', 403);
        }

        $data['tickets'] = $this->Ticket_model->obtener_todos_los_tickets();
        $this->load->view('lista_tickets_alta', $data);
    }


    // Mostrar formulario de nuevo ticket (solo para cliente)
    public function nuevo() {
        if ($this->session->userdata('rol') !== 'cliente') {
            show_error('No tienes permiso para acceder a esta página.', 403);
        }

        $this->load->view('registro_ticket');
    }

    // Guardar ticket (solo cliente)
   public function registrar() {
    // Validar que el usuario tenga rol 'cliente'
    if ($this->session->userdata('rol') !== 'cliente') {
        show_error('No tienes permiso para acceder a esta página.', 403);
    }

    // Recoger datos del formulario incluyendo 'solicitud'
    $data = array(
        'motivo'               => $this->input->post('motivo'),
        'estado'               => $this->input->post('estado'),
        'responsable_ejecucion'=> $this->input->post('responsable_ejecucion'),
        'solicitante'          => $this->input->post('solicitante'),
        'aprobador'            => $this->input->post('aprobador'),
        'accion'               => $this->input->post('accion'),
        'aplicacion'           => $this->input->post('aplicacion'),
        'responsable_app'      => $this->session->userdata('nombre'),  // Nombre del usuario logueado
        'tipo_usuario'         => $this->input->post('tipo_usuario'),
        'correo_usuario'       => $this->input->post('correo_usuario')
    );

    // Guardar ticket en la base de datos
    $ticket_id = $this->Ticket_model->guardar_ticket($data);

    // Flashdata para confirmar registro
    $this->session->set_flashdata('ticket_registrado', true);

    // Redirigir a la página de nuevo ticket o listado
    redirect('tickets/nuevo');
}

public function cambiar_estado()
{
    $id = $this->input->post('id_ticket');
    $estado = $this->input->post('estado');

    $this->Ticket_model->actualizar_estado($id, $estado);

    echo json_encode(["ok" => true]);
}

public function eliminar()
{
    $id = $this->input->post('id_ticket');

    $this->Ticket_model->eliminar($id);

    echo json_encode(["ok" => true]);
}





}
