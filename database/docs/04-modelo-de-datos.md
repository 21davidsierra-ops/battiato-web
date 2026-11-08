# Modelo de datos (MySQL `battiato_db`)

Definido en `database/schema.sql`.

```mermaid
erDiagram
    categories ||--o{ subcategories : "tiene"
    categories ||--o{ menu_items : "contiene"
    subcategories |o--o{ menu_items : "agrupa"

    admins {
        int id PK
        varchar username UK
        varchar password_hash
        timestamp created_at
    }
    categories {
        int id PK
        enum section
        varchar name
        varchar slug UK
        varchar icon
        int sort_order
        tinyint active
    }
    subcategories {
        int id PK
        int category_id FK
        varchar name
        int sort_order
    }
    menu_items {
        int id PK
        int category_id FK
        int subcategory_id FK
        varchar name
        text description
        decimal price
        varchar price_note
        int sort_order
        tinyint active
        timestamp created_at
        timestamp updated_at
    }
    pizza_sizes {
        int id PK
        varchar name
        tinyint slices
        decimal price
        int sort_order
        tinyint active
    }
```

- Al borrar una categoría se borran sus subcategorías y productos (`ON DELETE CASCADE`).
- Al borrar una subcategoría, sus productos quedan sin subcategoría (`ON DELETE SET NULL`).
