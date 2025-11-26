<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Lista de Tickets</title>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/lista_tickets.css'); ?>">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
</head>

<body>
    <div class="container" style="display: flex; justify-content: flex-end; gap: 10px; margin-bottom: 20px;">
        <a href="<?php echo site_url('auth/logout'); ?>" class="btn-logout">Cerrar Sesión</a>
        <a href="<?php echo site_url('usuario/index'); ?>" class="btn-logout">Registrar usuario</a>
    </div>

    <h2>Lista de Tickets</h2>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Motivo</th>
                <th>Estado</th>
                <th>Responsable Ejecución</th>
                <th>Solicitante</th>
                <th>Aprobador</th>
                <th>Acción</th>
                <th>Aplicación</th>
                <th>Responsable App</th>
                <th>Tipo Usuario</th>
                <th>Correo Usuario</th>
                <th>Fecha</th>
                <th>Opciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tickets as $ticket): ?>
                <tr id="fila_<?php echo $ticket->id_ticket; ?>">
                    <td><?php echo $ticket->id_ticket; ?></td>
                    <td><?php echo htmlspecialchars($ticket->motivo); ?></td>

                    <!-- SELECT para cambiar el estado -->
                    <td>
                        <select class="cambiar-estado" data-id="<?php echo $ticket->id_ticket; ?>">
                            <option value="pendiente"  <?= $ticket->estado == "pendiente" ? "selected" : "" ?>>Pendiente</option>
                            <option value="derivado" <?= $ticket->estado == "derivado" ? "selected" : "" ?>>Derivado</option>
                            <option value="realizado" <?= $ticket->estado == "realizado" ? "selected" : "" ?>>Realizado</option>
                        </select>
                    </td>

                    <td><?php echo htmlspecialchars($ticket->responsable_ejecucion); ?></td>
                    <td><?php echo htmlspecialchars($ticket->solicitante); ?></td>
                    <td><?php echo htmlspecialchars($ticket->aprobador); ?></td>
                    <td><?php echo htmlspecialchars($ticket->accion); ?></td>
                    <td><?php echo htmlspecialchars($ticket->aplicacion); ?></td>
                    <td><?php echo htmlspecialchars($ticket->responsable_app); ?></td>
                    <td><?php echo htmlspecialchars($ticket->tipo_usuario); ?></td>
                    <td><?php echo htmlspecialchars($ticket->correo_usuario); ?></td>
                    <td><?php echo $ticket->fecha; ?></td>

                    <!-- Botón eliminar -->
                    <td>
                        <button class="btn-eliminar" data-id="<?php echo $ticket->id_ticket; ?>">🗑 Eliminar</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // CAMBIAR ESTADO
        $(".cambiar-estado").change(function () {
            let id = $(this).data("id");
            let estado = $(this).val();

            $.post("<?php echo site_url('tickets/cambiar_estado'); ?>", {
                id_ticket: id,
                estado: estado
            }, function (respuesta) {

                Swal.fire({
                    icon: 'success',
                    title: 'Actualizado',
                    text: 'El estado del ticket fue cambiado correctamente'
                });

            }, "json");
        });


        // ELIMINAR TICKET
        $(".btn-eliminar").click(function () {
            let id = $(this).data("id");

            Swal.fire({
                title: "¿Eliminar ticket?",
                text: "Esta acción no se puede deshacer",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Sí, eliminar",
                cancelButtonText: "Cancelar"
            }).then((result) => {

                if (result.isConfirmed) {

                    $.post("<?php echo site_url('tickets/eliminar'); ?>", {
                        id_ticket: id
                    }, function (respuesta) {

                        $("#fila_" + id).remove();

                        Swal.fire({
                            icon: "success",
                            title: "Eliminado",
                            text: "El ticket fue eliminado correctamente"
                        });

                    }, "json");

                }
            });
        });
    </script>

</body>
</html>
