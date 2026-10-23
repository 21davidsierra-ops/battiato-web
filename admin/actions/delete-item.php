<?php
/*==========================================================
    DELETE-ITEM.PHP
    Elimina un producto del menú.
==========================================================*/

require_once __DIR__ . '/../includes/auth.php';

requireLogin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../index.php');
    exit;
}

verifyCsrfToken($_POST['csrf_token'] ?? null);

$pdo = getDbConnection();

$id         = (int) ($_POST['id'] ?? 0);
$categoryId = (int) ($_POST['category_id'] ?? 0);

if ($id > 0) {
    $stmt = $pdo->prepare('DELETE FROM menu_items WHERE id = :id');
    $stmt->execute(['id' => $id]);
}

header('Location: ../items.php?category_id=' . $categoryId);
exit;
