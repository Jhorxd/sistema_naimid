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
        if ($this->session->userdata('rol') !== 'soporte') {
            show_error('No tienes permiso para acceder a esta página.', 403);
        }

        $data['tickets'] = $this->Ticket_model->obtener_todos_los_tickets();
        $this->load->view('lista_tickets', $data);
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
        'correo_usuario'       => $this->input->post('correo_usuario'),
        'solicitud'            => $this->input->post('solicitud')      // Nuevo campo agregado
    );

    // Guardar ticket en la base de datos
    $ticket_id = $this->Ticket_model->guardar_ticket($data);

    // Flashdata para confirmar registro
    $this->session->set_flashdata('ticket_registrado', true);

    // Redirigir a la página de nuevo ticket o listado
    redirect('tickets/nuevo');
}

    public function mis_tickets() {
    // Reemplaza con la sesión real del cliente cuando la tengas
    $id_usuario = $this->session->userdata('id_usuario'); 

    // Validación temporal
    if (!$id_usuario) {
        redirect('auth/login');
    }

    $data['tickets'] = $this->Ticket_model->obtener_tickets_por_usuario($id_usuario);
    $this->load->view('cliente_tickets', $data);
}

public function eliminar($id_ticket) {
    // Verifica si el usuario está logueado
    if (!$this->session->userdata('id_usuario')) {
        redirect('auth/login');
    }

    // Intentar eliminar el ticket
    if ($this->Ticket_model->eliminar_ticket($id_ticket)) {
        $this->session->set_flashdata('success', 'Ticket eliminado correctamente.');
    } else {
        $this->session->set_flashdata('error', 'No se pudo eliminar el ticket.');
    }

    redirect('tickets/mis_tickets'); // O la ruta que uses para listar los tickets del cliente
}

public function actualizar_prioridad() {
    $id = $this->input->post('id_ticket');
    $prioridad = $this->input->post('prioridad');

    $this->load->model('Ticket_model');
    $this->Ticket_model->actualizar_prioridad($id, $prioridad);
}


public function ajax_evidencias($id_ticket)
{
    $this->load->model('Ticket_model');
    $evidencias = $this->Ticket_model->get_evidencias_por_ticket($id_ticket);
    $ticket = $this->Ticket_model->get_ticket($id_ticket); // método que devuelve el ticket con descripción

    $response = [
        'evidencias' => $evidencias,
        'descripcion' => $ticket->descripcion
    ];

    header('Content-Type: application/json');
    echo json_encode($response);
}



}
