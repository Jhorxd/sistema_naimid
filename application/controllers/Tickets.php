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
    if ($this->session->userdata('rol') !== 'cliente') {
        show_error('No tienes permiso para acceder a esta página.', 403);
    }

    $data = array(
        'id_usuario'  => $this->session->userdata('id_usuario'),
        'titulo'      => $this->input->post('titulo'),
        'descripcion' => $this->input->post('descripcion'),
    );

    $ticket_id = $this->Ticket_model->guardar_ticket($data);

    // Subida de evidencia (opcional)
    if (!empty($_FILES['evidencia']['name'])) {
        $upload_path = './uploads/';

        // Crear carpeta si no existe
        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0777, true);
        }

        $config['upload_path']   = $upload_path;
        $config['allowed_types'] = 'jpg|jpeg|png|gif|pdf|docx|zip|mp4|mov|avi|mkv|webm';
        $config['file_name']     = time() . '_' . $_FILES['evidencia']['name'];
        $config['max_size']      = 102400; // 100MB

        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if ($this->upload->do_upload('evidencia')) {
            $archivo = $this->upload->data();
            $evidencia = array(
                'id_ticket'      => $ticket_id,
                'nombre_archivo' => $archivo['file_name'],
                'ruta_archivo'   => 'uploads/' . $archivo['file_name'],
                'subido_en'      => date('Y-m-d H:i:s')
            );
            $this->Ticket_model->guardar_evidencia($evidencia);
        } else {
            log_message('error', 'Error al subir evidencia: ' . $this->upload->display_errors());
        }
    }

    // Aquí seteamos el flashdata para la alerta
    $this->session->set_flashdata('ticket_registrado', true);

    // Redirigimos a la página donde está el formulario (o la vista que uses)
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
