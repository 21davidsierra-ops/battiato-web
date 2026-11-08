<?php
/*==========================================================
    SETUP.PHP
    Restaurante Bar Battiato — Panel de Administración

    Script de UN SOLO USO para crear el primer usuario admin.
    Genera el hash de la contraseña con password_hash(), que es
    la forma segura de hacerlo (nunca escribas contraseñas ni
    hashes a mano en el SQL).

    ⚠️ IMPORTANTE: apenas crees tu usuario, BORRA este archivo
    o renómbralo. Si ya existe un admin en la base de datos,
    este script se niega a crear otro (para que no quede
    expuesto en producción).
==========================================================*/

require_once __DIR__ . '/../config/database.php';

$pdo = getDbConnection();

$alreadyHasAdmin = (int) $pdo->query('SELECT COUNT(*) FROM admins')->fetchColumn() > 0;

$message = '';
$success = false;

if ($alreadyHasAdmin) {
    $message = 'Ya existe un usuario administrador. Por seguridad, este script no permite crear otro. '
              . 'Si necesitas restablecer tu contraseña, hazlo directamente en phpMyAdmin o bórrame y crea el flujo que prefieras.';
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm  = $_POST['password_confirm'] ?? '';

    if ($username === '' || $password === '') {
        $message = 'Usuario y contraseña son obligatorios.';
    } elseif (strlen($password) < 8) {
        $message = 'La contraseña debe tener al menos 8 caracteres.';
    } elseif ($password !== $confirm) {
        $message = 'Las contraseñas no coinciden.';
    } else {
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare('INSERT INTO admins (username, password_hash) VALUES (:username, :hash)');
        $stmt->execute(['username' => $username, 'hash' => $hash]);

        $success = true;
        $message = 'Usuario creado correctamente. Ya puedes borrar este archivo (setup.php) y entrar en login.php.';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Configuración inicial — Battiato Admin</title>
    <link rel="stylesheet" href="assets/admin.css">
</head>
<body class="admin-auth-page">

    <div class="admin-auth-box">

        <h1>Crear usuario administrador</h1>

        <?php if ($message): ?>
            <p class="admin-alert <?= $success ? 'admin-alert--ok' : 'admin-alert--error' ?>">
                <?= htmlspecialchars($message) ?>
            </p>
        <?php endif; ?>

        <?php if (!$alreadyHasAdmin && !$success): ?>
            <form method="post">
                <label>Usuario
                    <input type="text" name="username" required autofocus>
                </label>

                <label>Contraseña (mínimo 8 caracteres)
                    <input type="password" name="password" required minlength="8">
                </label>

                <label>Confirmar contraseña
                    <input type="password" name="password_confirm" required minlength="8">
                </label>

                <button type="submit" class="admin-btn admin-btn--primary">Crear usuario</button>
            </form>
        <?php endif; ?>

        <?php if ($success): ?>
            <a class="admin-btn admin-btn--primary" href="login.php">Ir a iniciar sesión</a>
        <?php endif; ?>

    </div>

</body>
</html>
