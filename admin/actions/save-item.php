<?php
/*==========================================================
    SAVE-ITEM.PHP
    Crea o actualiza un producto del menú.
==========================================================*/

require_once __DIR__ . '/../includes/auth.php';

requireLogin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../index.php');
    exit;
}

verifyCsrfToken($_POST['csrf_token'] ?? null);

$pdo = getDbConnection();

$id            = isset($_POST['id']) ? (int) $_POST['id'] : null;
$categoryId    = (int) ($_POST['category_id'] ?? 0);
$subcategoryId = $_POST['subcategory_id'] ?? '';
$subcategoryId = $subcategoryId === '' ? null : (int) $subcategoryId;
$name          = trim($_POST['name'] ?? '');
$description   = trim($_POST['description'] ?? '');
$price         = (float) ($_POST['price'] ?? 0);
$priceNote     = trim($_POST['price_note'] ?? '');
$sortOrder     = (int) ($_POST['sort_order'] ?? 0);
$active        = isset($_POST['active']) ? 1 : 0;

// Validaciones mínimas del lado del servidor.

if ($categoryId <= 0) {
    die('Categoría inválida.');
}

if ($name === '') {
    die('El nombre del producto es obligatorio.');
}

if ($price < 0) {
    die('El precio no puede ser negativo.');
}

$description = $description === '' ? null : $description;
$priceNote   = $priceNote === '' ? null : $priceNote;

if ($id) {

    // ----- Actualizar producto existente -----

    $stmt = $pdo->prepare(
        'UPDATE menu_items
         SET category_id = :category_id,
             subcategory_id = :subcategory_id,
             name = :name,
             description = :description,
             price = :price,
             price_note = :price_note,
             sort_order = :sort_order,
             active = :active
         WHERE id = :id'
    );

    $stmt->execute([
        'category_id'    => $categoryId,
        'subcategory_id' => $subcategoryId,
        'name'           => $name,
        'description'    => $description,
        'price'          => $price,
        'price_note'     => $priceNote,
        'sort_order'     => $sortOrder,
        'active'         => $active,
        'id'             => $id,
    ]);

} else {

    // ----- Crear producto nuevo -----

    $stmt = $pdo->prepare(
        'INSERT INTO menu_items
            (category_id, subcategory_id, name, description, price, price_note, sort_order, active)
         VALUES
            (:category_id, :subcategory_id, :name, :description, :price, :price_note, :sort_order, :active)'
    );

    $stmt->execute([
        'category_id'    => $categoryId,
        'subcategory_id' => $subcategoryId,
        'name'           => $name,
        'description'    => $description,
        'price'          => $price,
        'price_note'     => $priceNote,
        'sort_order'     => $sortOrder,
        'active'         => $active,
    ]);
}

header('Location: ../items.php?category_id=' . $categoryId);
exit;
