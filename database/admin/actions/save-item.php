<?php
/*==========================================================
    SAVE-ITEM.PHP
    Crea o actualiza un producto del menú.
    Usa el módulo Battiato\Menu (validador, entidad y repositorio).
==========================================================*/

require_once __DIR__ . '/../includes/auth.php';

use Battiato\Menu\MenuItem;
use Battiato\Menu\MenuItemRepository;
use Battiato\Menu\MenuItemValidator;

requireLogin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../index.php');
    exit;
}

verifyCsrfToken($_POST['csrf_token'] ?? null);

// Validaciones del lado del servidor.

$errors = (new MenuItemValidator())->validate($_POST);

if ($errors !== []) {
    http_response_code(422);
    echo '<!DOCTYPE html><meta charset="utf-8"><title>Datos inválidos</title>';
    echo '<p>No se guardó el producto:</p><ul>';
    foreach ($errors as $error) {
        echo '<li>' . htmlspecialchars($error) . '</li>';
    }
    echo '</ul><p><a href="javascript:history.back()">Volver al formulario</a></p>';
    exit;
}

// Guardar: actualizar si el formulario trae id, crear si no.

$item = MenuItem::fromInput($_POST);
$repository = new MenuItemRepository(getDbConnection());

if ($item->getId() !== null) {
    $repository->update($item);
} else {
    $repository->create($item);
}

header('Location: ../items.php?category_id=' . $item->getCategoryId());
exit;
