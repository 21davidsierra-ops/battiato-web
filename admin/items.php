<?php
/*==========================================================
    ITEMS.PHP
    Lista, agrega y edita los productos de una categoría.
    Restaurante Bar Battiato
==========================================================*/

require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/../includes/menu-data.php';

requireLogin();

$pdo = getDbConnection();

$categoryId = (int) ($_GET['category_id'] ?? 0);

$catStmt = $pdo->prepare('SELECT * FROM categories WHERE id = :id');
$catStmt->execute(['id' => $categoryId]);
$category = $catStmt->fetch();

if (!$category) {
    http_response_code(404);
    die('Categoría no encontrada.');
}

$subcategories = getSubcategories($categoryId);

$action = $_GET['action'] ?? 'list';
$editingItem = null;

if ($action === 'edit') {
    $itemId = (int) ($_GET['id'] ?? 0);
    $itemStmt = $pdo->prepare('SELECT * FROM menu_items WHERE id = :id AND category_id = :cat');
    $itemStmt->execute(['id' => $itemId, 'cat' => $categoryId]);
    $editingItem = $itemStmt->fetch();

    if (!$editingItem) {
        $action = 'list';
    }
}

$pageTitle = $category['name'];
require __DIR__ . '/includes/header.php';
?>

<div class="admin-breadcrumb">
    <a href="index.php">Panel</a> / <?= htmlspecialchars($category['name']) ?>
</div>

<?php if ($action === 'new' || $action === 'edit'): ?>

    <!-- ==========================
         FORMULARIO NUEVO / EDITAR
    =========================== -->

    <div class="admin-header">
        <h1><?= $editingItem ? 'Editar producto' : 'Nuevo producto' ?></h1>
        <a href="items.php?category_id=<?= $categoryId ?>" class="admin-btn admin-btn--ghost">
            <i class="fa-solid fa-arrow-left"></i> Volver al listado
        </a>
    </div>

    <form class="admin-form" method="post" action="actions/save-item.php">

        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrfToken()) ?>">
        <input type="hidden" name="category_id" value="<?= $categoryId ?>">
        <?php if ($editingItem): ?>
            <input type="hidden" name="id" value="<?= (int) $editingItem['id'] ?>">
        <?php endif; ?>

        <label>Nombre del producto
            <input type="text" name="name" required
                   value="<?= htmlspecialchars($editingItem['name'] ?? '') ?>">
        </label>

        <?php if (!empty($subcategories)): ?>
            <label>Subcategoría
                <select name="subcategory_id">
                    <option value="">— Sin subcategoría —</option>
                    <?php foreach ($subcategories as $sc): ?>
                        <option value="<?= (int) $sc['id'] ?>"
                            <?= (isset($editingItem['subcategory_id']) && (int) $editingItem['subcategory_id'] === (int) $sc['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($sc['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </label>
        <?php endif; ?>

        <label>Descripción (opcional)
            <textarea name="description"><?= htmlspecialchars($editingItem['description'] ?? '') ?></textarea>
        </label>

        <div class="admin-form__row">

            <label>Precio (COP)
                <input type="number" name="price" step="100" min="0" required
                       value="<?= htmlspecialchars($editingItem['price'] ?? '') ?>">
            </label>

            <label>Nota de precio (opcional)
                <input type="text" name="price_note" placeholder='Ej: "Sin papas", "Por 450gm"'
                       value="<?= htmlspecialchars($editingItem['price_note'] ?? '') ?>">
            </label>

        </div>

        <label>Orden de aparición
            <input type="number" name="sort_order" min="0"
                   value="<?= htmlspecialchars($editingItem['sort_order'] ?? '0') ?>">
        </label>

        <label style="flex-direction:row;align-items:center;gap:10px;">
            <input type="checkbox" name="active" value="1" style="width:auto;"
                <?= (!$editingItem || $editingItem['active']) ? 'checked' : '' ?>>
            Visible en el sitio público
        </label>

        <div class="admin-form__actions">
            <button type="submit" class="admin-btn admin-btn--primary">
                <i class="fa-solid fa-floppy-disk"></i> Guardar
            </button>
            <a href="items.php?category_id=<?= $categoryId ?>" class="admin-btn admin-btn--ghost">Cancelar</a>
        </div>

    </form>

<?php else: ?>

    <!-- ==========================
         LISTADO DE PRODUCTOS
    =========================== -->

    <div class="admin-header">
        <h1><?= htmlspecialchars($category['name']) ?></h1>
    </div>

    <div class="admin-toolbar">
        <span style="color:var(--color-gray-dark);font-size:.85rem;">
            Los cambios de precio se reflejan de inmediato en el sitio.
        </span>
        <a href="items.php?category_id=<?= $categoryId ?>&action=new" class="admin-btn admin-btn--primary">
            <i class="fa-solid fa-plus"></i> Nuevo producto
        </a>
    </div>

    <table class="admin-table">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Precio</th>
                <th>Estado</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $grouped = getItemsGroupedByCategory($categoryId);

            if (empty($grouped)):
            ?>
                <tr class="admin-table__empty">
                    <td colspan="4">Todavía no hay productos en esta categoría.</td>
                </tr>
            <?php
            else:
                foreach ($grouped as $subcatName => $items):
                    if ($subcatName !== ''):
            ?>
                        <tr class="admin-subhead">
                            <td colspan="4"><?= htmlspecialchars($subcatName) ?></td>
                        </tr>
            <?php
                    endif;
                    foreach ($items as $item):
            ?>
                <tr>
                    <td>
                        <strong><?= htmlspecialchars($item['name']) ?></strong>
                        <?php if ($item['description']): ?>
                            <br><span class="admin-table__note"><?= htmlspecialchars($item['description']) ?></span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <span class="admin-table__price"><?= formatPrice((float) $item['price']) ?></span>
                        <?php if ($item['price_note']): ?>
                            <br><span class="admin-table__note"><?= htmlspecialchars($item['price_note']) ?></span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?= $item['active'] ? '<span style="color:var(--color-success)">Visible</span>' : '<span style="color:var(--color-gray-dark)">Oculto</span>' ?>
                    </td>
                    <td class="admin-table__actions">
                        <a href="items.php?category_id=<?= $categoryId ?>&action=edit&id=<?= (int) $item['id'] ?>"
                           class="admin-btn admin-btn--ghost admin-btn--sm">
                            <i class="fa-solid fa-pen"></i>
                        </a>
                        <form method="post" action="actions/delete-item.php"
                              onsubmit="return confirm('¿Eliminar «<?= htmlspecialchars(addslashes($item['name'])) ?>»?');">
                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrfToken()) ?>">
                            <input type="hidden" name="id" value="<?= (int) $item['id'] ?>">
                            <input type="hidden" name="category_id" value="<?= $categoryId ?>">
                            <button type="submit" class="admin-btn admin-btn--danger admin-btn--sm">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            <?php
                    endforeach;
                endforeach;
            endif;
            ?>
        </tbody>
    </table>

<?php endif; ?>

<?php require __DIR__ . '/includes/footer.php'; ?>
