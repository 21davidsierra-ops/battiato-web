<?php
/*==========================================================
    HEADER.PHP (parcial)
    Incluir después de requireLogin(). Espera opcionalmente
    una variable $pageTitle definida antes del include.
    Todas las páginas del panel viven directamente en admin/,
    así que las rutas relativas son siempre las mismas.
==========================================================*/

$pageTitle = $pageTitle ?? 'Panel';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?> — Battiato Admin</title>
    <link rel="stylesheet" href="assets/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>
<body>

    <header class="admin-topbar">

        <div class="admin-topbar__brand">

            <i class="fa-solid fa-utensils" style="color:var(--color-primary)"></i>

            Battiato <span>Admin</span>

        </div>

        <nav class="admin-topbar__nav">

            <a href="index.php" class="admin-btn admin-btn--ghost admin-btn--sm">
                <i class="fa-solid fa-gauge"></i> Panel
            </a>

            <a href="../index.php" target="_blank" class="admin-btn admin-btn--ghost admin-btn--sm">
                <i class="fa-solid fa-arrow-up-right-from-square"></i> Ver sitio
            </a>

            <a href="logout.php" class="admin-btn admin-btn--danger admin-btn--sm">
                <i class="fa-solid fa-right-from-bracket"></i> Salir
            </a>

        </nav>

    </header>

    <main class="admin-main">
