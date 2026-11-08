<?php
/*==========================================================
    PIZZA-SIZES.PHP
    Edita los precios por tamaño de Pizza Plazza.
    Restaurante Bar Battiato
==========================================================*/

require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/../includes/menu-data.php';

requireLogin();

$sizes = getPizzaSizes();

$pageTitle = 'Tamaños de Pizza';
require __DIR__ . '/includes/header.php';
?>

<div class="admin-breadcrumb">
    <a href="index.php">Panel</a> / Tamaños y precios
</div>

<div class="admin-header">
    <h1>Tamaños y precios de Pizza Plazza</h1>
</div>

<p style="color:var(--color-gray-dark);font-size:.85rem;margin-bottom:20px;">
    El precio de una pizza depende del tamaño elegido, no del sabor.
    Estos precios se muestran en la sección "Pizza Plazza" del sitio.
</p>

<form class="admin-form" method="post" action="actions/save-pizza-sizes.php" style="max-width:700px;">

    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrfToken()) ?>">

    <?php foreach ($sizes as $size): ?>

        <div class="admin-form__row admin-form__row--pizza-size">

            <label>
                <?= htmlspecialchars($size['name']) ?><?= $size['slices'] ? ' (x' . (int) $size['slices'] . ')' : '' ?>
                <input type="hidden" name="ids[]" value="<?= (int) $size['id'] ?>">
                <input type="text" value="<?= htmlspecialchars($size['name']) ?>" disabled>
            </label>

            <label>Precio (COP)
                <input type="number" name="prices[]" step="100" min="0" required
                       value="<?= htmlspecialchars($size['price']) ?>">
            </label>

            <label style="flex-direction:row;align-items:center;gap:8px;">
                <input type="checkbox" name="active[<?= (int) $size['id'] ?>]" value="1" style="width:auto;"
                    <?= $size['active'] ? 'checked' : '' ?>>
                Visible
            </label>

        </div>

    <?php endforeach; ?>

    <div class="admin-form__actions">
        <button type="submit" class="admin-btn admin-btn--primary">
            <i class="fa-solid fa-floppy-disk"></i> Guardar precios
        </button>
    </div>

</form>

<?php require __DIR__ . '/includes/footer.php'; ?>
