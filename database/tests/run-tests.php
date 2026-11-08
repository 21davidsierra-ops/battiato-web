<?php

declare(strict_types=1);

/*==========================================================
    RUN-TESTS.PHP
    Restaurante Bar Battiato — pruebas del módulo de menú

    No necesita instalar nada. Se ejecuta desde la terminal:

        php tests/run-tests.php

    Usa una base de datos SQLite en memoria (no toca tu MySQL).
    Termina con código 0 si todo pasa y 1 si algo falla.
==========================================================*/

require_once __DIR__ . '/../includes/menu-data.php';

use Battiato\Core\Database;
use Battiato\Menu\MenuItem;
use Battiato\Menu\MenuItemRepository;
use Battiato\Menu\MenuItemValidator;

// ---------- Mini marco de pruebas ----------

$passed = 0;
$failed = 0;

function check(string $description, bool $condition): void
{
    global $passed, $failed;

    if ($condition) {
        $passed++;
        echo "  [OK]    $description\n";
    } else {
        $failed++;
        echo "  [FALLA] $description\n";
    }
}

function section(string $title): void
{
    echo "\n$title\n" . str_repeat('-', strlen($title)) . "\n";
}

function validInput(array $overrides = []): array
{
    return array_merge([
        'category_id'    => '1',
        'subcategory_id' => '',
        'name'           => 'Hamburguesa especial',
        'description'    => '',
        'price'          => '18900',
        'price_note'     => '',
        'sort_order'     => '0',
    ], $overrides);
}

function hasError(array $errors, string $fragment): bool
{
    foreach ($errors as $error) {
        if (stripos($error, $fragment) !== false) {
            return true;
        }
    }

    return false;
}

// ---------- Base de datos de prueba (SQLite en memoria) ----------

$pdo = new PDO('sqlite::memory:', null, null, [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
]);

$pdo->exec('CREATE TABLE categories (
    id INTEGER PRIMARY KEY AUTOINCREMENT, section TEXT, name TEXT, slug TEXT UNIQUE,
    icon TEXT, sort_order INTEGER DEFAULT 0, active INTEGER DEFAULT 1)');
$pdo->exec('CREATE TABLE subcategories (
    id INTEGER PRIMARY KEY AUTOINCREMENT, category_id INTEGER, name TEXT, sort_order INTEGER DEFAULT 0)');
$pdo->exec('CREATE TABLE menu_items (
    id INTEGER PRIMARY KEY AUTOINCREMENT, category_id INTEGER NOT NULL, subcategory_id INTEGER NULL,
    name TEXT NOT NULL, description TEXT NULL, price DECIMAL(10,2) NOT NULL, price_note TEXT NULL,
    sort_order INTEGER DEFAULT 0, active INTEGER DEFAULT 1)');

$pdo->exec("INSERT INTO categories (section, name, slug) VALUES ('restaurante', 'Burgers', 'burgers')");
$pdo->exec("INSERT INTO subcategories (category_id, name) VALUES (1, 'Clásicas')");

Database::setConnection($pdo);

// ---------- 1. Autoload ----------

section('1. Carga automática de clases (paquetes Battiato\\Core y Battiato\\Menu)');

check('Se carga Battiato\\Menu\\MenuItem', class_exists(MenuItem::class));
check('Se carga Battiato\\Menu\\MenuItemRepository', class_exists(MenuItemRepository::class));
check('Se carga Battiato\\Menu\\MenuItemValidator', class_exists(MenuItemValidator::class));
check('Se carga Battiato\\Core\\Database', class_exists(Database::class));
check('Database devuelve la conexión inyectada', Database::getConnection() === $pdo);

// ---------- 2. Validador ----------

section('2. MenuItemValidator (casos válidos, vacíos, extremos e inválidos)');

$validator = new MenuItemValidator();

check('Datos válidos no generan errores', $validator->validate(validInput()) === []);
check('Nombre vacío se rechaza', hasError($validator->validate(validInput(['name' => '   '])), 'obligatorio'));
check('Nombre de 150 caracteres se acepta', $validator->validate(validInput(['name' => str_repeat('a', 150)])) === []);
check('Nombre de 151 caracteres se rechaza', hasError($validator->validate(validInput(['name' => str_repeat('a', 151)])), 'superar'));
check('150 letras "ñ" (300 bytes) se aceptan: se cuentan caracteres', $validator->validate(validInput(['name' => str_repeat('ñ', 150)])) === []);
check('Precio "abc" se rechaza (antes se guardaba como $0)', hasError($validator->validate(validInput(['price' => 'abc'])), 'número'));
check('Precio vacío se rechaza', hasError($validator->validate(validInput(['price' => ''])), 'número'));
check('Precio negativo se rechaza', hasError($validator->validate(validInput(['price' => '-5'])), 'negativo'));
check('Precio 0 se acepta', $validator->validate(validInput(['price' => '0'])) === []);
check('Precio con decimales se acepta', $validator->validate(validInput(['price' => '16900.50'])) === []);
check('Precio absurdo (1e12) se rechaza', hasError($validator->validate(validInput(['price' => '1e12'])), 'alto'));
check('Categoría 0 se rechaza', hasError($validator->validate(validInput(['category_id' => '0'])), 'Categoría'));
check('Categoría "x" se rechaza', hasError($validator->validate(validInput(['category_id' => 'x'])), 'Categoría'));
check('Subcategoría inválida se rechaza', hasError($validator->validate(validInput(['subcategory_id' => 'abc'])), 'Subcategoría'));
check('Nota de precio de 61 caracteres se rechaza', hasError($validator->validate(validInput(['price_note' => str_repeat('n', 61)])), 'nota'));
check('Orden negativo se rechaza', hasError($validator->validate(validInput(['sort_order' => '-1'])), 'orden'));
check('Orden vacío se acepta', $validator->validate(validInput(['sort_order' => ''])) === []);

// ---------- 3. Entidad ----------

section('3. MenuItem (entidad)');

$fromForm = MenuItem::fromInput(validInput([
    'name' => '  Smash  ', 'description' => '  ', 'price_note' => ' con papas ',
    'subcategory_id' => '1', 'active' => '1', 'id' => '0',
]));

check('fromInput recorta el nombre', $fromForm->getName() === 'Smash');
check('fromInput deja la descripción vacía como null', $fromForm->getDescription() === null);
check('fromInput recorta la nota de precio', $fromForm->getPriceNote() === 'con papas');
check('fromInput: id 0 equivale a producto nuevo (null)', $fromForm->getId() === null);
check('fromInput: la casilla marcada activa el producto', $fromForm->isActive() === true);
check('fromInput: sin casilla el producto queda oculto', MenuItem::fromInput(validInput())->isActive() === false);
check('withId devuelve una copia con id', $fromForm->withId(7)->getId() === 7 && $fromForm->getId() === null);

$fromRow = MenuItem::fromRow([
    'id' => '3', 'category_id' => '1', 'subcategory_id' => null, 'name' => 'Papas',
    'description' => null, 'price' => '23900.00', 'price_note' => null, 'sort_order' => '2', 'active' => '1',
]);

check('fromRow convierte tipos (id int, precio float)', $fromRow->getId() === 3 && $fromRow->getPrice() === 23900.0);
check('toArray usa llaves snake_case y active 1/0', $fromRow->toArray()['category_id'] === 1 && $fromRow->toArray()['active'] === 1);

// ---------- 4. Repositorio (CRUD) ----------

section('4. MenuItemRepository (insertar, consultar, actualizar, eliminar)');

$repository = new MenuItemRepository($pdo);

$idA = $repository->create(new MenuItem(null, 1, null, 'Especial Res', 'Carne 150 g', 18900.0, null, 2, true));
$idB = $repository->create(new MenuItem(null, 1, 1, 'Clásica', null, 15000.0, null, 1, true));
$idC = $repository->create(new MenuItem(null, 1, null, 'Smash', null, 17900.0, '(sin papas)', 1, true));
$idD = $repository->create(new MenuItem(null, 1, null, 'Plato oculto', null, 9900.0, null, 3, false));

check('INSERTAR: create devuelve un id mayor que cero', $idA > 0 && $idB > $idA);

$found = $repository->findById($idA);
check('CONSULTAR: findById devuelve el producto con sus datos',
    $found !== null && $found->getName() === 'Especial Res' && $found->getPrice() === 18900.0
    && $found->getDescription() === 'Carne 150 g');
check('CONSULTAR: findById de un id inexistente devuelve null', $repository->findById(9999) === null);

$names = array_map(static fn (MenuItem $i): string => $i->getName(), $repository->findByCategory(1));
check('CONSULTAR: findByCategory ordena (sin subcategoría primero, luego por orden)', $names === ['Smash', 'Especial Res', 'Clásica']);
check('CONSULTAR: findByCategory público excluye los ocultos', !in_array('Plato oculto', $names, true));

$allNames = array_map(static fn (MenuItem $i): string => $i->getName(), $repository->findByCategory(1, false));
check('CONSULTAR: findByCategory del panel incluye los ocultos', in_array('Plato oculto', $allNames, true) && count($allNames) === 4);
check('CONSULTAR: categoría sin productos devuelve arreglo vacío', $repository->findByCategory(55) === []);

$updated = new MenuItem($idA, 1, null, 'Especial Res XL', 'Carne 200 g', 21900.0, null, 2, true);
check('ACTUALIZAR: update devuelve true si el producto existe', $repository->update($updated) === true);
$reloaded = $repository->findById($idA);
check('ACTUALIZAR: los cambios quedan guardados', $reloaded !== null && $reloaded->getName() === 'Especial Res XL' && $reloaded->getPrice() === 21900.0);
check('ACTUALIZAR: update de un id inexistente devuelve false', $repository->update(new MenuItem(9999, 1, null, 'X', null, 1.0, null, 0, true)) === false);

$threw = false;
try {
    $repository->update(new MenuItem(null, 1, null, 'Sin id', null, 1.0, null, 0, true));
} catch (InvalidArgumentException $exception) {
    $threw = true;
}
check('ACTUALIZAR: un producto sin id lanza InvalidArgumentException', $threw);

check('ELIMINAR: delete devuelve true si existía', $repository->delete($idC) === true);
check('ELIMINAR: el producto ya no se encuentra', $repository->findById($idC) === null);
check('ELIMINAR: delete de un id inexistente devuelve false', $repository->delete($idC) === false);

// ---------- 5. Integración con menu-data.php (lo que usa el sitio) ----------

section('5. Integración: funciones de menu-data.php sobre el módulo');

check('formatPrice(16900) = "$16.900"', formatPrice(16900) === '$16.900');
check('formatPrice(1234567) = "$1.234.567"', formatPrice(1234567) === '$1.234.567');
check('formatPrice(0) = "$0"', formatPrice(0) === '$0');

$publicItems = getItemsByCategory(1);
check('getItemsByCategory devuelve arreglos con llaves de la tabla', array_key_exists('name', $publicItems[0]) && array_key_exists('price_note', $publicItems[0]));
check('getItemsByCategory (público) no trae los ocultos', count($publicItems) === 2);
check('getItemsByCategory(…, false) (panel) sí trae los ocultos', count(getItemsByCategory(1, false)) === 3);

$grouped = getItemsGroupedByCategory(1);
check('getItemsGroupedByCategory agrupa por nombre de subcategoría', isset($grouped['Clásica']) === false && isset($grouped['Clásicas'][0]) && $grouped['Clásicas'][0]['name'] === 'Clásica');
check('getItemsGroupedByCategory deja los items sin subcategoría bajo la llave vacía', isset($grouped['']) && count($grouped['']) === 1);

$repository->create(new MenuItem(null, 1, null, '<b>Plato</b>', null, 12000.0, null, 9, true));
ob_start();
renderPriceList('burgers');
$html = (string) ob_get_clean();
check('renderPriceList muestra nombre y precio formateado', str_contains($html, 'Especial Res XL') && str_contains($html, '$21.900'));
check('renderPriceList no muestra los productos ocultos', !str_contains($html, 'Plato oculto'));
check('renderPriceList escapa el HTML de los nombres', str_contains($html, '&lt;b&gt;Plato&lt;/b&gt;') && !str_contains($html, '<b>Plato</b>'));

ob_start();
renderPriceList('no-existe');
check('renderPriceList de un slug inexistente no imprime nada', ob_get_clean() === '');

// ---------- Resumen ----------

echo "\n==============================\n";
echo "Pruebas correctas: $passed\n";
echo "Pruebas fallidas:  $failed\n";
echo "==============================\n";

exit($failed === 0 ? 0 : 1);
