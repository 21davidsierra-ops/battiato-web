<?php
/*==========================================================
    INDEX.PHP — Dashboard del panel
    Restaurante Bar Battiato
==========================================================*/

require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/../includes/menu-data.php';

requireLogin();

$pdo = getDbConnection();

// Conteo de items activos por categoría, en una sola consulta.
$counts = [];
$countStmt = $pdo->query(
    'SELECT category_id, COUNT(*) AS total
     FROM menu_items
     WHERE active = 1
     GROUP BY category_id'
);
foreach ($countStmt->fetchAll() as $row) {
    $counts[(int) $row['category_id']] = (int) $row['total'];
}

$restauranteCategories = getCategories('restaurante');
$pizzaCategories       = getCategories('pizza');

$pageTitle = 'Panel';
require __DIR__ . '/includes/header.php';
?>

<div class="admin-header">
    <h1>Bienvenido, <?= htmlspecialchars($_SESSION['admin_username']) ?></h1>
</div>

<h2 style="margin-bottom:15px;font-size:1.1rem;color:var(--color-gray);">Menú del restaurante</h2>

<div class="admin-grid" style="margin-bottom:40px;">

    <?php foreach ($restauranteCategories as $cat): ?>

        <a href="items.php?category_id=<?= (int) $cat['id'] ?>" class="admin-card">

            <i class="<?= htmlspecialchars($cat['icon'] ?? 'fa-solid fa-utensils') ?>"></i>

            <h3><?= htmlspecialchars($cat['name']) ?></h3>

            <p><?= $counts[$cat['id']] ?? 0 ?> productos</p>

        </a>

    <?php endforeach; ?>

</div>

<h2 style="margin-bottom:15px;font-size:1.1rem;color:var(--color-gray);">Pizza Plazza</h2>

<div class="admin-grid">

    <a href="pizza-sizes.php" class="admin-card">

        <i class="fa-solid fa-ruler-combined"></i>

        <h3>Tamaños y precios</h3>

        <p>Personal, Jumbo, Mediana, Grande, Familiar</p>

    </a>

    <?php foreach ($pizzaCategories as $cat): ?>

        <a href="items.php?category_id=<?= (int) $cat['id'] ?>" class="admin-card">

            <i class="<?= htmlspecialchars($cat['icon'] ?? 'fa-solid fa-pizza-slice') ?>"></i>

            <h3><?= htmlspecialchars($cat['name']) ?></h3>

            <p><?= $counts[$cat['id']] ?? 0 ?> sabores</p>

        </a>

    <?php endforeach; ?>

</div>

<?php require __DIR__ . '/includes/footer.php'; ?>
