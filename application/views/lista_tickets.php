<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Lista de Tickets</title>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/lista_tickets.css'); ?>">
    <!-- SweetAlert2 CSS -->
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
                <th>Título</th>
                <th>Prioridad</th>
                <th>Estado</th>
                <th>Creado en</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tickets as $ticket): ?>
                <tr>
                    <td><?php echo $ticket->id_ticket; ?></td>
                    <td><?php echo htmlspecialchars($ticket->titulo); ?></td>
                    <td>
                        <select class="cambiar-prioridad" data-id="<?php echo $ticket->id_ticket; ?>">
                            <option value="alta" <?php echo $ticket->prioridad === 'alta' ? 'selected' : ''; ?>>Alta</option>
                            <option value="media" <?php echo $ticket->prioridad === 'media' ? 'selected' : ''; ?>>Media</option>
                            <option value="baja" <?php echo $ticket->prioridad === 'baja' ? 'selected' : ''; ?>>Baja</option>
                        </select>
                    </td>
                    <td><?php echo ucfirst($ticket->estado); ?></td>
                    <td><?php echo $ticket->creado_en; ?></td>
                    <td>
                        <a href="javascript:void(0);" class="btn-ver" data-id="<?php echo $ticket->id_ticket; ?>">Ver</a> |
                        <a href="#">Responder</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function () {
            // Funcionalidad botón Ver
            $('.btn-ver').on('click', function () {
                const ticketId = $(this).data('id');

                $.ajax({
                    url: '<?php echo site_url('tickets/ajax_evidencias'); ?>/' + ticketId,
                    method: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        const evidencias = data.evidencias || [];
                        const descripcion = data.descripcion || 'Sin descripción disponible';

                        if (evidencias.length === 0) {
                            // Sin evidencias, mostrar modal con botón Ver detalles
                            Swal.fire({
                                title: 'Sin evidencia',
                                text: 'No hay evidencia para este ticket.',
                                icon: 'info',
                                showCancelButton: true,
                                confirmButtonText: 'Cerrar',
                                cancelButtonText: 'Ver detalles',
                                reverseButtons: true
                            }).then((result) => {
                                if (result.dismiss === Swal.DismissReason.cancel) {
                                    Swal.fire({
                                        title: 'Descripción del ticket',
                                        html: `<p style="white-space: pre-wrap;">${descripcion}</p>`,
                                        icon: 'info',
                                        confirmButtonText: 'Cerrar'
                                    });
                                }
                            });
                            return;
                        }

                        // Hay evidencias, mostrar modal con evidencias y botón Ver detalles
                        let html = '';
                        evidencias.forEach(ev => {
                            const ext = ev.nombre_archivo.split('.').pop().toLowerCase();
                            const url = '<?php echo base_url(); ?>' + ev.ruta_archivo;
                            if (['jpg','jpeg','png','gif','webp'].includes(ext)) {
                                html += `<div style="margin-bottom:10px"><img src="${url}" alt="${ev.nombre_archivo}" style="max-width:100%;max-height:200px;"/></div>`;
                            } else if (['mp4','mov','avi','mkv','webm'].includes(ext)) {
                                html += `<div style="margin-bottom:10px"><video src="${url}" controls style="max-width:100%;max-height:200px;"></video></div>`;
                            } else if (['pdf'].includes(ext)) {
                                html += `<div style="margin-bottom:10px"><a href="${url}" target="_blank">Ver PDF: ${ev.nombre_archivo}</a></div>`;
                            } else if (['docx','zip'].includes(ext)) {
                                html += `<div style="margin-bottom:10px"><a href="${url}" target="_blank" download>Descargar: ${ev.nombre_archivo}</a></div>`;
                            } else {
                                html += `<div style="margin-bottom:10px"><a href="${url}" target="_blank" download>${ev.nombre_archivo}</a></div>`;
                            }
                        });

                        Swal.fire({
                            title: 'Evidencias',
                            html: html,
                            width: 600,
                            showCloseButton: true,
                            showCancelButton: true,
                            confirmButtonText: 'Cerrar',
                            cancelButtonText: 'Ver detalles',
                            reverseButtons: true
                        }).then((result) => {
                            if (result.dismiss === Swal.DismissReason.cancel) {
                                Swal.fire({
                                    title: 'Descripción del ticket',
                                    html: `<p style="white-space: pre-wrap;">${descripcion}</p>`,
                                    icon: 'info',
                                    confirmButtonText: 'Cerrar'
                                });
                            }
                        });
                    },
                    error: function () {
                        Swal.fire('Error', 'No se pudo cargar la evidencia.', 'error');
                    }
                });
            });

            // Funcionalidad para cambiar prioridad
            $('.cambiar-prioridad').on('change', function () {
                const id_ticket = $(this).data('id');
                const nueva_prioridad = $(this).val();

                $.ajax({
                    url: '<?php echo site_url('tickets/actualizar_prioridad'); ?>',
                    method: 'POST',
                    data: {
                        id_ticket: id_ticket,
                        prioridad: nueva_prioridad
                    },
                    success: function (response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Éxito',
                            text: 'Prioridad actualizada correctamente',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    },
                    error: function () {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Hubo un error al actualizar la prioridad',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    }
                });
            });
        });
    </script>
</body>

</html>
