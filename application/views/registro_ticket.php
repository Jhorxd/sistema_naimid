<!DOCTYPE html>
<html>

<head>
    <title>Registrar Ticket</title>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/registro_ticket.css'); ?>">

    <!-- Incluir SweetAlert desde CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

    <div class="header">
        <h2>Registrar Ticket</h2>

        <div class="container">
            <a href="<?php echo site_url('tickets/mis_tickets'); ?>" class="btn-ver-tickets">Ver mis Tickets</a>
            <a href="<?php echo site_url('auth/logout'); ?>" class="btn-logout">Cerrar Sesión</a>
        </div>
    </div>

    <?php echo form_open('tickets/registrar', ['id' => 'formRegistrarTicket']); ?>

    <label>Motivo:</label>
    <select name="motivo" required>
        <option value="">Seleccione un motivo</option>
        <option value="Control de Proveedores">Control de Proveedores</option>
        <option value="Control de recertificación de accesos">Control de recertificación de accesos</option>
        <option value="Requerimiento">Requerimiento</option>
        <option value="Sinceramiento">Sinceramiento</option>
    </select>

    <label>Estado:</label>
    <select name="estado" required>
        <option value="">Seleccione estado</option>
        <option value="derivado">Derivado</option>
        <option value="realizado">Realizado</option>
    </select>

    <label>Acción:</label>
    <select name="accion" required>
        <option value="">Seleccione acción</option>
        <option value="Creacion">Creación</option>
        <option value="Cambio de perfil">Cambio de perfil</option>
        <option value="Eliminacion">Eliminación</option>
        <option value="Reseteo">Reseteo</option>
        <option value="Modificacion">Modificación</option>
        <option value="Bloqueo">Bloqueo</option>
        <option value="Reseteo MFA">Reseteo MFA</option>
    </select>

    <label>Responsable de ejecución:</label>
    <input type="text" name="responsable_ejecucion" required>

    <label>Solicitante:</label>
    <input type="text" name="solicitante" required>

    <label>Aprobador de la solicitud:</label>
    <input type="text" name="aprobador" required>

    <label>Aplicación:</label>
    <input type="text" name="aplicacion" required>

    <label>Responsable de la app:</label>
    <input type="text" name="responsable_app" value="<?php echo $this->session->userdata('nombre'); ?>" readonly>

    <label>Tipo de usuario:</label>
    <input type="text" name="tipo_usuario" required>

    <label>Correo del usuario:</label>
    <input type="text" name="correo_usuario" required>

    <label>Solicitud:</label>
    <select name="solicitud" required>
        <option value="">Seleccione una opción</option>
        <option value="alta">Alta</option>
        <option value="baja">Baja</option>
    </select>

    <button type="submit">Registrar Ticket</button>

    <?php echo form_close(); ?>

    <?php if ($this->session->flashdata('ticket_registrado')): ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: '¡Ticket registrado!',
                text: 'Tu ticket ha sido registrado correctamente.',
                confirmButtonText: 'Aceptar'
            });
        </script>
    <?php endif; ?>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('formRegistrarTicket');

        form.addEventListener('submit', function (e) {
            e.preventDefault(); // Evita el envío inmediato

            Swal.fire({
                title: '¿Estás seguro?',
                text: "¿Quieres registrar este ticket?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Sí, registrar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
    </script>

</body>

</html>
