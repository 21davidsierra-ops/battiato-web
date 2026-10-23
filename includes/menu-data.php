<?php
/*==========================================================
    MENU-DATA.PHP
    Restaurante Bar Battiato

    Funciones de solo lectura para traer el menú desde MySQL.
    Las usa tanto el sitio público (index.php) como, si quieres
    reutilizarlas, el panel de administración.
==========================================================*/

require_once __DIR__ . '/../config/database.php';

/**
 * Da formato de precio colombiano: 16900 -> "$16.900"
 */
function formatPrice(float $price): string
{
    return '$' . number_format($price, 0, ',', '.');
}

/**
 * Trae las categorías activas de una sección ('restaurante' o 'pizza'),
 * ordenadas por sort_order.
 */
function getCategories(string $section): array
{
    $pdo = getDbConnection();

    $stmt = $pdo->prepare(
        'SELECT * FROM categories
         WHERE section = :section AND active = 1
         ORDER BY sort_order ASC'
    );
    $stmt->execute(['section' => $section]);

    return $stmt->fetchAll();
}

/**
 * Trae las subcategorías de una categoría, ordenadas.
 */
function getSubcategories(int $categoryId): array
{
    $pdo = getDbConnection();

    $stmt = $pdo->prepare(
        'SELECT * FROM subcategories
         WHERE category_id = :category_id
         ORDER BY sort_order ASC'
    );
    $stmt->execute(['category_id' => $categoryId]);

    return $stmt->fetchAll();
}

/**
 * Trae los items activos de una categoría (todas sus subcategorías
 * incluidas), ordenados por subcategoría y luego por sort_order.
 */
function getItemsByCategory(int $categoryId): array
{
    $pdo = getDbConnection();

    $stmt = $pdo->prepare(
        'SELECT * FROM menu_items
         WHERE category_id = :category_id AND active = 1
         ORDER BY subcategory_id IS NULL DESC, subcategory_id ASC, sort_order ASC'
    );
    $stmt->execute(['category_id' => $categoryId]);

    return $stmt->fetchAll();
}

/**
 * Agrupa los items de una categoría por nombre de subcategoría.
 * Devuelve un arreglo asociativo: [nombre_subcategoria => [items...]]
 * Los items sin subcategoría quedan bajo la llave '' (vacía).
 */
function getItemsGroupedByCategory(int $categoryId): array
{
    $items = getItemsByCategory($categoryId);
    $subcats = getSubcategories($categoryId);

    $names = [];
    foreach ($subcats as $sc) {
        $names[$sc['id']] = $sc['name'];
    }

    $grouped = [];
    foreach ($items as $item) {
        $key = $item['subcategory_id'] !== null
            ? ($names[$item['subcategory_id']] ?? '')
            : '';
        $grouped[$key][] = $item;
    }

    return $grouped;
}

/**
 * Trae una categoría por su slug (ej: 'parrilla', 'bebidas').
 * Devuelve null si no existe o está inactiva.
 */
function getCategoryBySlug(string $slug): ?array
{
    $pdo = getDbConnection();

    $stmt = $pdo->prepare(
        'SELECT * FROM categories WHERE slug = :slug AND active = 1 LIMIT 1'
    );
    $stmt->execute(['slug' => $slug]);
    $row = $stmt->fetch();

    return $row ?: null;
}

/**
 * Imprime la lista de precios (HTML) de una categoría dado su slug.
 * Pensada para insertarse debajo de cada panel de imagen del menú,
 * para que el precio mostrado siempre esté actualizado aunque la
 * imagen del cartel no se haya vuelto a diseñar.
 */
function renderPriceList(string $slug): void
{
    $category = getCategoryBySlug($slug);

    if (!$category) {
        return;
    }

    $grouped = getItemsGroupedByCategory((int) $category['id']);

    if (empty($grouped)) {
        return;
    }

    echo '<div class="menu-pricelist">';
    echo '<h4 class="menu-pricelist__title"><i class="fa-solid fa-tag"></i> Precios actualizados</h4>';

    foreach ($grouped as $subcatName => $items) {
        if ($subcatName !== '') {
            echo '<p class="menu-pricelist__group">' . htmlspecialchars($subcatName) . '</p>';
        }

        echo '<ul class="menu-pricelist__items">';

        foreach ($items as $item) {
            echo '<li>';
            echo '<span class="menu-pricelist__name">' . htmlspecialchars($item['name']);
            if ($item['price_note']) {
                echo ' <em>(' . htmlspecialchars($item['price_note']) . ')</em>';
            }
            echo '</span>';
            echo '<span class="menu-pricelist__price">' . formatPrice((float) $item['price']) . '</span>';
            echo '</li>';
        }

        echo '</ul>';
    }

    echo '</div>';
}

/**
 * Imprime la lista de sabores (HTML) de una categoría de pizza,
 * dado su slug. A diferencia de renderPriceList(), no muestra
 * precio individual: el precio de una pizza depende del tamaño
 * elegido (ver pizza_sizes / renderPriceList no aplica aquí).
 */
function renderFlavorList(string $slug): void
{
    $category = getCategoryBySlug($slug);

    if (!$category) {
        return;
    }

    $items = getItemsByCategory((int) $category['id']);

    if (empty($items)) {
        return;
    }

    echo '<div class="menu-pricelist menu-pricelist--flavors">';
    echo '<h4 class="menu-pricelist__title"><i class="fa-solid fa-pizza-slice"></i> '
        . htmlspecialchars($category['name']) . '</h4>';
    echo '<ul class="menu-pricelist__items menu-pricelist__items--flavors">';

    foreach ($items as $item) {
        echo '<li>';
        echo '<span class="menu-pricelist__name">' . htmlspecialchars($item['name']) . '</span>';
        if ($item['description']) {
            echo '<span class="menu-pricelist__desc">' . htmlspecialchars($item['description']) . '</span>';
        }
        echo '</li>';
    }

    echo '</ul>';
    echo '</div>';
}

/**
 * Trae los tamaños de pizza activos, ordenados.
 */
function getPizzaSizes(): array
{
    $pdo = getDbConnection();

    $stmt = $pdo->query(
        'SELECT * FROM pizza_sizes
         WHERE active = 1
         ORDER BY sort_order ASC'
    );

    return $stmt->fetchAll();
}
