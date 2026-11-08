# Diagrama de clases y arquitectura

## Diagrama de clases

Los paquetes (espacios de nombres) son `Battiato\Core` y `Battiato\Menu`, y cada uno corresponde a una carpeta dentro de `src/`.

```mermaid
classDiagram
    direction LR

    namespace Core {
        class Database {
            -PDO connection$
            +getConnection()$ PDO
            +setConnection(PDO connection)$ void
        }
    }

    namespace Menu {
        class MenuItem {
            -int id
            -int categoryId
            -int subcategoryId
            -string name
            -string description
            -float price
            -string priceNote
            -int sortOrder
            -bool active
            +fromRow(array row)$ MenuItem
            +fromInput(array input)$ MenuItem
            +withId(int id) MenuItem
            +getId() int
            +getCategoryId() int
            +getSubcategoryId() int
            +getName() string
            +getDescription() string
            +getPrice() float
            +getPriceNote() string
            +getSortOrder() int
            +isActive() bool
            +toArray() array
        }

        class MenuItemValidator {
            +MAX_NAME_LENGTH int
            +MAX_PRICE_NOTE_LENGTH int
            +MAX_PRICE float
            +validate(array input) array
        }

        class MenuItemRepository {
            -PDO pdo
            +create(MenuItem item) int
            +findById(int id) MenuItem
            +findByCategory(int categoryId, bool onlyActive) array
            +update(MenuItem item) bool
            +delete(int id) bool
        }
    }

    class PDO {
        <<extensión de PHP>>
    }

    MenuItemRepository ..> MenuItem : guarda y devuelve
    MenuItemRepository ..> PDO : usa la conexión que recibe
    Database ..> PDO : crea la conexión
```

El `MenuItemValidator` no depende de otras clases: recibe el arreglo del formulario y devuelve los errores. Si no hay errores, `MenuItem::fromInput()` construye el producto con esos mismos datos.

## Arquitectura por capas

```mermaid
flowchart TB
    NAV[Navegador] --> PUB[index.php<br/>sitio público]
    NAV --> ADM[admin/*.php<br/>panel de administración]
    PUB --> MD[includes/menu-data.php<br/>consultas y listas de precios]
    ADM --> MD
    ADM --> ACT[admin/actions/*.php<br/>guardar y eliminar]
    ACT --> VAL[Battiato\Menu\MenuItemValidator]
    ACT --> REP[Battiato\Menu\MenuItemRepository]
    MD --> REP
    MD -. obtiene la conexión .-> DB[Battiato\Core\Database]
    ACT -. obtiene la conexión .-> DB
    DB --> SQL[(MySQL battiato_db)]
    REP --> SQL
```

`getDbConnection()` (en `config/database.php`) es un atajo de `Database::getConnection()`. Las funciones de `includes/menu-data.php` y `admin/includes/auth.php` siguen siendo procedurales; el módulo de productos (CRUD) es el que está orientado a objetos.
