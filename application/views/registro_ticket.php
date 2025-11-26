<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Registrar Ticket</title>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/registro_ticket.css'); ?>">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div class="main-wrapper">

        <div class="header">
            <h2>Registrar Ticket</h2>
            <div class="container">
                <!-- <a href="<//?php echo site_url('tickets/mis_tickets'); ?>" class="btn-ver-tickets">Ver mis Tickets</a> -->
                <a href="<?php echo site_url('auth/logout'); ?>" class="btn-logout">Cerrar Sesión</a>
            </div>
        </div>

        <?php echo form_open('tickets/registrar', ['id' => 'formRegistrarTicket']); ?>

        <label for="motivo">Motivo:</label>
        <select name="motivo" id="motivo" required>
            <option value="">Seleccione un motivo</option>
            <option value="Control de Proveedores">Control de Proveedores</option>
            <option value="Control de recertificación de accesos">Control de recertificación de accesos</option>
            <option value="Requerimiento">Requerimiento</option>
            <option value="Sinceramiento">Sinceramiento</option>
        </select>

        <label for="estado">Estado:</label>
        <select name="estado" id="estado" required>
            <option value="">Seleccione estado</option>
            <option value="derivado">Derivado</option>
            <option value="realizado">Realizado</option>
        </select>

        <label for="accion">Acción:</label>
        <select name="accion" id="accion" required>
            <option value="">Seleccione acción</option>
            <option value="Creacion">Creación</option>
            <option value="Cambio de perfil">Cambio de perfil</option>
            <option value="Eliminacion">Eliminación</option>
            <option value="Reseteo">Reseteo</option>
            <option value="Modificacion">Modificación</option>
            <option value="Bloqueo">Bloqueo</option>
            <option value="Reseteo MFA">Reseteo MFA</option>
        </select>

        <label for="responsable_ejecucion">Responsable de ejecución:</label>
        <input type="text" name="responsable_ejecucion" id="responsable_ejecucion" required>

        <label for="solicitante">Solicitante:</label>
        <input type="text" name="solicitante" id="solicitante" required>

        <label for="aprobador">Aprobador de la solicitud:</label>
        <input type="text" name="aprobador" id="aprobador" required>

        <label for="aplicacion">Aplicación:</label>
        <input type="text" name="aplicacion" id="aplicacion" required>

        <label for="responsable_app">Responsable de la app:</label>
        <input type="text" name="responsable_app" id="responsable_app" value="<?php echo $this->session->userdata('nombre'); ?>" readonly>

        <label for="tipo_usuario">Tipo de usuario:</label>
        <input type="text" name="tipo_usuario" id="tipo_usuario" required>

        <label for="correo_usuario">Correo del usuario:</label>
        <input type="text" name="correo_usuario" id="correo_usuario" required>

        <button type="submit">Registrar Ticket</button>

        <?php echo form_close(); ?>

    </div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('formRegistrarTicket');

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        Swal.fire({
            title: '¿Estás seguro?',
            text: "¿Quieres registrar este ticket?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Sí, registrar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {

            if (result.isConfirmed) {

                // Mostrar mensaje "registrado"
                Swal.fire({
                    icon: 'success',
                    title: 'Ticket registrado',
                    text: 'El ticket se ha registrado correctamente.',
                    timer: 2000,
                    showConfirmButton: false
                });

                // Enviar formulario después de mostrar el mensaje
                setTimeout(() => {
                    form.submit();
                }, 2000);
            }
        });
    });
});
</script>

</body>

</html>
