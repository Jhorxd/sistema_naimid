<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/login.css'); ?>">
</head>
<body>

    <!-- Logo Culqi centrado -->
    <img src="<?php echo base_url('assets/img/logo1.jpeg'); ?>" alt="Logo Culqi" class="logo-login">

    <h2>Iniciar sesión</h2>

    <?php if ($this->session->flashdata('error')): ?>
        <p class="login-error"><?php echo $this->session->flashdata('error'); ?></p>
    <?php endif; ?>

    <form method="post" action="<?php echo site_url('auth/login'); ?>">
        <label for="correo">Correo:</label>
        <input type="email" name="correo" id="correo" required>

        <label for="contraseña">Contraseña:</label>
        <input type="password" name="contraseña" id="contraseña" required>

        <button type="submit">Iniciar sesión</button>
    </form>

</body>
</html>
