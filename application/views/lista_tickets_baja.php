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
        <a href="<?php echo site_url('tickets'); ?>" class="btn-logout">Ver "Altas"</a>
        <a href="<?php echo site_url('usuario/index'); ?>" class="btn-logout">Registrar usuario</a>
    </div>

    <h2>Lista de Tickets (Solicitud: Baja)</h2>

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
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tickets as $ticket): ?>
                <tr>
                    <td><?php echo $ticket->id_ticket; ?></td>
                    <td><?php echo htmlspecialchars($ticket->motivo); ?></td>
                    <td><?php echo ucfirst($ticket->estado); ?></td>
                    <td><?php echo htmlspecialchars($ticket->responsable_ejecucion); ?></td>
                    <td><?php echo htmlspecialchars($ticket->solicitante); ?></td>
                    <td><?php echo htmlspecialchars($ticket->aprobador); ?></td>
                    <td><?php echo htmlspecialchars($ticket->accion); ?></td>
                    <td><?php echo htmlspecialchars($ticket->aplicacion); ?></td>
                    <td><?php echo htmlspecialchars($ticket->responsable_app); ?></td>
                    <td><?php echo htmlspecialchars($ticket->tipo_usuario); ?></td>
                    <td><?php echo htmlspecialchars($ticket->correo_usuario); ?></td>
                    <td><?php echo $ticket->fecha; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>

</html>
