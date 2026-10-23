<?php
/*==========================================================
    SAVE-PIZZA-SIZES.PHP
    Actualiza los precios (y visibilidad) de los tamaños de pizza.
==========================================================*/

require_once __DIR__ . '/../includes/auth.php';

requireLogin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../pizza-sizes.php');
    exit;
}

verifyCsrfToken($_POST['csrf_token'] ?? null);

$pdo = getDbConnection();

$ids     = $_POST['ids'] ?? [];
$prices  = $_POST['prices'] ?? [];
$actives = $_POST['active'] ?? []; // [id => '1'] solo para los marcados

$stmt = $pdo->prepare('UPDATE pizza_sizes SET price = :price, active = :active WHERE id = :id');

foreach ($ids as $index => $id) {
    $id    = (int) $id;
    $price = (float) ($prices[$index] ?? 0);
    $active = isset($actives[$id]) ? 1 : 0;

    if ($id > 0 && $price >= 0) {
        $stmt->execute([
            'price'  => $price,
            'active' => $active,
            'id'     => $id,
        ]);
    }
}

header('Location: ../pizza-sizes.php');
exit;
