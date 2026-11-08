# Estándares de codificación

Basados en **PSR-1**, **PSR-4** y **PSR-12**, los estándares de la comunidad PHP. El proyecto los aplica así:

## Nombramiento

| Elemento | Regla | Ejemplos reales del proyecto |
|---|---|---|
| **Variables** | `camelCase`, nombres descriptivos en inglés; sin abreviaturas, salvo `$pdo` | `$categoryId`, `$onlyActive`, `$subcategoryId` |
| **Métodos y funciones** | `camelCase`, empiezan con un verbo | `findByCategory()`, `validate()`, `getDbConnection()`, `formatPrice()` |
| **Clases** | `PascalCase`, sustantivos; una clase por archivo con el mismo nombre | `MenuItem`, `MenuItemRepository`, `MenuItemValidator`, `Database` |
| **Paquetes (espacios de nombres)** | `PascalCase`, raíz `Battiato`; cada paquete es una carpeta de `src/` (PSR-4) | `Battiato\Core` → `src/Core/`, `Battiato\Menu` → `src/Menu/` |
| **Constantes** | `MAYUSCULAS_CON_GUION_BAJO` | `MAX_NAME_LENGTH`, `DB_HOST` |
| **Propiedades** | `camelCase`, privadas con *getters* | `$priceNote` → `getPriceNote()` |
| **Métodos booleanos** | Prefijo `is` | `isActive()` |
| **Métodos de fábrica** | Prefijo `from` | `MenuItem::fromRow()`, `MenuItem::fromInput()` |
| **Tablas y columnas (SQL)** | `snake_case`; tablas en plural, columnas en singular | `menu_items`, `category_id`, `price_note` |
| **CSS** | Metodología BEM: `bloque__elemento--modificador` | `.menu-pricelist__title`, `.price-card__price` |
| **JavaScript** | `camelCase`; identificadores HTML en `camelCase` | `navToggle`, `closeMenu()` |
| **Archivos PHP** | Clases con el nombre de la clase; scripts en `kebab-case` | `MenuItem.php`, `save-item.php` |

## Estilo de código

- Sangría de 4 espacios, sin tabulaciones; llaves de apertura de clases y métodos en la línea siguiente (PSR-12).
- Archivos de clases con `declare(strict_types=1);` y tipos declarados en parámetros y retornos.
- Una sola responsabilidad por clase: `MenuItem` guarda datos, `MenuItemValidator` valida, `MenuItemRepository` accede a la base de datos.
- Cada clase y método público lleva un comentario de documentación con `@param`, `@return` y `@throws` cuando aplica.
- Consultas SQL siempre preparadas, con parámetros con nombre (`:category_id`); nunca se concatenan datos del usuario.
- Todo texto que llega al HTML se escapa con `htmlspecialchars()`.
- Mensajes para el usuario en español; identificadores en inglés.

## Control de versiones

- Repositorio Git (GitHub y GitLab), rama principal `main`.
- Una rama por tarea (por ejemplo `feature/modulo-menu-poo` o `fix/responsive`) y un commit por cambio con un mensaje que diga qué se hizo.
- `config/database.php` no se sube al repositorio; se sube `config/database.example.php`.
