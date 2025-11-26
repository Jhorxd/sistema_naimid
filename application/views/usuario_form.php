<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Registrar Usuario</title>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/usuario_form.css'); ?>">
</head>

<body>
    <div class="main-wrapper">
        <div class="header">
            <h2>Registrar usuario</h2>
            <div class="container">
                <a href="<?php echo site_url('tickets/index'); ?>" class="btn-ver-tickets">Ver Tickets</a>
                <a href="<?php echo site_url('auth/logout'); ?>" class="btn-logout">Cerrar Sesión</a>
            </div>
        </div>

        <?php if ($this->session->flashdata('msg')): ?>
            <p class="msg"><?php echo $this->session->flashdata('msg'); ?></p>
        <?php endif; ?>

        <form method="post" action="<?php echo base_url('usuario/guardar'); ?>">
            <label>Nombre:</label>
            <input type="text" name="nombre" required>

            <label>Correo:</label>
            <input type="email" name="correo" required>

            <label>Contraseña:</label>
            <input type="password" name="contraseña" required>

            <label>Rol:</label>
            <select name="rol" required>
                <option value="admin">Admin</option>
                <option value="cliente">Cliente</option>
            </select>

            <button type="submit">Guardar</button>
        </form>
    </div>
</body>

</html>
