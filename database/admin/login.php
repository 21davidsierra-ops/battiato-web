<?php
/*==========================================================
    LOGIN.PHP
    Restaurante Bar Battiato — Panel de Administración
==========================================================*/

require_once __DIR__ . '/includes/auth.php';

if (isLoggedIn()) {
    header('Location: index.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verifyCsrfToken($_POST['csrf_token'] ?? null);

    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (attemptLogin($username, $password)) {
        header('Location: index.php');
        exit;
    }

    $error = 'Usuario o contraseña incorrectos.';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión — Battiato Admin</title>
    <link rel="stylesheet" href="assets/admin.css">
</head>
<body class="admin-auth-page">

    <div class="admin-auth-box">

        <h1>Panel de administración</h1>
        <p class="admin-auth-subtitle">Restaurante Bar Battiato</p>

        <?php if ($error): ?>
            <p class="admin-alert admin-alert--error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form method="post">

            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrfToken()) ?>">

            <label>Usuario
                <input type="text" name="username" required autofocus>
            </label>

            <label>Contraseña
                <input type="password" name="password" required>
            </label>

            <button type="submit" class="admin-btn admin-btn--primary">Entrar</button>

        </form>

    </div>

</body>
</html>
