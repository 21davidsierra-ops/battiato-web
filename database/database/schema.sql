-- ==========================================================
--  BASE DE DATOS: battiato_db
--  Restaurante Bar Battiato
--  Esquema + datos iniciales (carta actualizada, precios
--  junio 2026), para que el panel arranque ya poblado.
--
--  Si ya tienes una instalación anterior de esta base de
--  datos, NO vuelvas a correr este archivo completo — usa en
--  su lugar database/migracion-2026-06.sql, que solo agrega
--  lo nuevo sin borrar lo que ya tenías.
-- ==========================================================

CREATE DATABASE IF NOT EXISTS battiato_db
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE battiato_db;

-- ==========================================================
-- TABLA: admins
-- Usuarios que pueden entrar al panel de administración
-- ==========================================================

CREATE TABLE admins (
    id            INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username      VARCHAR(50)  NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    created_at    TIMESTAMP    DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ==========================================================
-- TABLA: categories
-- Las categorías del menú (Parrilla, Burgers, Bar, etc.) y
-- las de Pizza Plazza (Clásicas, Especiales, Nuevas).
-- 'section' distingue si pertenece al menú general o a pizza.
-- ==========================================================

CREATE TABLE categories (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    section     ENUM('restaurante','pizza') NOT NULL,
    name        VARCHAR(100) NOT NULL,
    slug        VARCHAR(100) NOT NULL UNIQUE,
    icon        VARCHAR(50)  NULL COMMENT 'clase de Font Awesome, ej: fa-solid fa-fire-burner',
    sort_order  INT UNSIGNED DEFAULT 0,
    active      TINYINT(1)   DEFAULT 1
) ENGINE=InnoDB;

-- ==========================================================
-- TABLA: subcategories
-- Subgrupos dentro de una categoría, ej: dentro de "Bebidas"
-- están "Limonadas", "Jugos", "Sodas Saborizadas", etc.
-- Es opcional: si una categoría no tiene subgrupos, sus items
-- simplemente no llevan subcategory_id.
-- ==========================================================

CREATE TABLE subcategories (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    category_id INT UNSIGNED NOT NULL,
    name        VARCHAR(100) NOT NULL,
    sort_order  INT UNSIGNED DEFAULT 0,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ==========================================================
-- TABLA: menu_items
-- Cada plato/bebida individual, con su precio.
-- price_note se usa para variantes de precio del mismo plato,
-- ej: "Sin papas" / "Con papas", o "Jarra" / "Copa".
-- ==========================================================

CREATE TABLE menu_items (
    id              INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    category_id     INT UNSIGNED NOT NULL,
    subcategory_id  INT UNSIGNED NULL,
    name            VARCHAR(150)   NOT NULL,
    description     TEXT           NULL,
    price           DECIMAL(10,2)  NOT NULL,
    price_note      VARCHAR(60)    NULL,
    sort_order      INT UNSIGNED   DEFAULT 0,
    active          TINYINT(1)     DEFAULT 1,
    created_at      TIMESTAMP      DEFAULT CURRENT_TIMESTAMP,
    updated_at      TIMESTAMP      DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE,
    FOREIGN KEY (subcategory_id) REFERENCES subcategories(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- ==========================================================
-- TABLA: pizza_sizes
-- Tamaños de Pizza Plazza (Personal, Jumbo, Mediana, Grande,
-- Familiar). El precio depende del tamaño, no del sabor.
-- ==========================================================

CREATE TABLE pizza_sizes (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(50)   NOT NULL,
    slices      TINYINT UNSIGNED NULL COMMENT 'número de porciones, NULL para Personal',
    price       DECIMAL(10,2) NOT NULL,
    sort_order  INT UNSIGNED DEFAULT 0,
    active      TINYINT(1)   DEFAULT 1
) ENGINE=InnoDB;

-- ==========================================================
-- SEED: admins
-- El usuario administrador NO se crea aquí (un hash de
-- contraseña escrito a mano en SQL no es seguro ni confiable).
-- Después de importar este esquema, abre en el navegador:
--   http://localhost/battiato-web1.1/admin/setup.php
-- ese script crea tu usuario y contraseña de forma segura y
-- luego se autodesactiva. Ver database/README.md.
-- ==========================================================

-- ==========================================================
-- SEED: categories (sección "restaurante")
-- ==========================================================

INSERT INTO categories (id, section, name, slug, icon, sort_order) VALUES
(1,  'restaurante', 'Parrilla',         'parrilla',  'fa-solid fa-fire-burner',          2),
(2,  'restaurante', 'Burgers',          'burgers',   'fa-solid fa-burger',               1),
(3,  'restaurante', 'Comida Mexicana',  'mexicana',  'fa-solid fa-pepper-hot',           3),
(4,  'restaurante', 'Pastas y Calzone', 'otros',     'fa-solid fa-bowl-food',            5),
(5,  'restaurante', 'Bebidas',          'bebidas',   'fa-solid fa-martini-glass-citrus', 6),
(9,  'restaurante', 'Papas Battiato',   'papas',     'fa-solid fa-utensils',             4),
(10, 'restaurante', 'Bar',              'bar',       'fa-solid fa-beer-mug-empty',       7),
(11, 'restaurante', 'Cafés',            'cafe',      'fa-solid fa-mug-saucer',           8);

-- ==========================================================
-- SEED: categories (sección "pizza")
-- ==========================================================

INSERT INTO categories (id, section, name, slug, icon, sort_order) VALUES
(6, 'pizza', 'Pizzas Clásicas',  'pizza-clasicas',  'fa-solid fa-pizza-slice', 1),
(7, 'pizza', 'Pizzas Especiales','pizza-especiales','fa-solid fa-star',        2),
(8, 'pizza', 'Pizzas Nuevas',    'pizza-nuevas',    'fa-solid fa-wand-magic-sparkles', 3);

-- ==========================================================
-- SEED: subcategories
-- ==========================================================

INSERT INTO subcategories (id, category_id, name, sort_order) VALUES
(1,  4,  'Lasañas',                     1),
(2,  4,  'Pastas',                      2),
(3,  4,  'Calzone',                     3),
(4,  4,  'Maicitos',                    4),
(5,  5,  'Limonadas',                   1),
(6,  5,  'Jugos',                       2),
(7,  5,  'Sodas Saborizadas',           3),
(8,  5,  'Guanabanon (bebida original de la casa)', 4),
(9,  5,  'Gaseosas',                    5),
(10, 1,  'Costichi',                    1),
(11, 1,  'Especiales de Pollo o Cerdo', 2),
(12, 10, 'Cócteles',                    1),
(13, 10, 'Cervezas',                    2),
(14, 10, 'Sangría',                     3),
(15, 11, 'Calientes',                   1),
(16, 11, 'Fríos',                       2);

-- ==========================================================
-- SEED: menu_items — PARRILLA (categoría 1)
-- ==========================================================

-- Costichi (subcategoría 10)
INSERT INTO menu_items (category_id, subcategory_id, name, description, price, price_note, sort_order) VALUES
(1, 10, 'Costichi BBQ',       'Corte de 300gm a la plancha en salsa BBQ.', 30900, 'Sin papas', 1),
(1, 10, 'Costichi BBQ',       'Corte de 300gm a la plancha en salsa BBQ.', 33900, 'Con papas', 2),
(1, 10, 'Costichi Mexicano',  'Acompañado de pico de gallo y opcional salsa picante de la casa.', 30900, 'Sin papas', 3),
(1, 10, 'Costichi Mexicano',  'Acompañado de pico de gallo y opcional salsa picante de la casa.', 33900, 'Con papas', 4),
(1, 10, 'Costichi Revuelto',  'Tocineta finamente picada salteada con maíz tierno y pico de gallo.', 31900, 'Sin papas', 5),
(1, 10, 'Costichi Revuelto',  'Tocineta finamente picada salteada con maíz tierno y pico de gallo.', 34900, 'Con papas', 6);

-- Especiales de Pollo o Cerdo (subcategoría 11)
INSERT INTO menu_items (category_id, subcategory_id, name, description, price, price_note, sort_order) VALUES
(1, 11, 'BBQ o Champiñones',      'Corte de pechuga de pollo o cerdo de 300gm en la salsa que más te guste.',        31500, 'Sin papas', 1),
(1, 11, 'BBQ o Champiñones',      'Corte de pechuga de pollo o cerdo de 300gm en la salsa que más te guste.',        34900, 'Con papas', 2),
(1, 11, 'Revuelto',               'Tocineta finamente picada, salteada con un poco de maíz tierno y pico de gallo.', 31500, 'Sin papas', 3),
(1, 11, 'Revuelto',               'Tocineta finamente picada, salteada con un poco de maíz tierno y pico de gallo.', 34900, 'Con papas', 4),
(1, 11, 'Mexicano',               'Cualquiera de los dos cortes, con pico de gallo, jalapeños y salsa BBQ.',         31900, 'Sin papas', 5),
(1, 11, 'Mexicano',               'Cualquiera de los dos cortes, con pico de gallo, jalapeños y salsa BBQ.',         34900, 'Con papas', 6),
(1, 11, 'Chuzo de Pollo',         'Chuzo de pollo y tocineta de 250gm, bañado en salsa BBQ.',                        25900, 'Sin papas', 7),
(1, 11, 'Chuzo de Pollo',         'Chuzo de pollo y tocineta de 250gm, bañado en salsa BBQ.',                        28900, 'Con papas', 8),
(1, 11, 'Punta de Anca de Cerdo', 'Corte de 300gm a la plancha en salsa BBQ.',                                       32900, 'Sin papas', 9),
(1, 11, 'Punta de Anca de Cerdo', 'Corte de 300gm a la plancha en salsa BBQ.',                                       35900, 'Con papas', 10);

-- ==========================================================
-- SEED: menu_items — BURGERS (categoría 2)
-- ==========================================================

INSERT INTO menu_items (category_id, name, description, price, price_note, sort_order) VALUES
(2, 'Especial Res',      'Con una carne. Todas nuestras hamburguesas vienen con tocineta, queso mozzarella, queso chédar, pepinillos, cebolla caramelizada, lechuga y tomate.', 18900, 'Sin papas', 1),
(2, 'Especial Res',      'Con una carne. Todas nuestras hamburguesas vienen con tocineta, queso mozzarella, queso chédar, pepinillos, cebolla caramelizada, lechuga y tomate.', 24900, 'Con papas', 2),
(2, 'Especial Pollo',    'Con un filete. Todas nuestras hamburguesas vienen con tocineta, queso mozzarella, queso chédar, pepinillos, cebolla caramelizada, lechuga y tomate.', 18900, 'Sin papas', 3),
(2, 'Especial Pollo',    'Con un filete. Todas nuestras hamburguesas vienen con tocineta, queso mozzarella, queso chédar, pepinillos, cebolla caramelizada, lechuga y tomate.', 24900, 'Con papas', 4),
(2, 'Puerquita',         'Con cerdo en tiras. Todas nuestras hamburguesas vienen con tocineta, queso mozzarella, queso chédar, pepinillos, cebolla caramelizada, lechuga y tomate.', 18900, 'Sin papas', 5),
(2, 'Puerquita',         'Con cerdo en tiras. Todas nuestras hamburguesas vienen con tocineta, queso mozzarella, queso chédar, pepinillos, cebolla caramelizada, lechuga y tomate.', 24900, 'Con papas', 6),
(2, 'Mexicana',          'Guacamole + jalapeño. Todas nuestras hamburguesas vienen con tocineta, queso mozzarella, queso chédar, pepinillos, cebolla caramelizada, lechuga y tomate.', 18900, 'Sin papas', 7),
(2, 'Mexicana',          'Guacamole + jalapeño. Todas nuestras hamburguesas vienen con tocineta, queso mozzarella, queso chédar, pepinillos, cebolla caramelizada, lechuga y tomate.', 24900, 'Con papas', 8),
(2, 'La Bistec',         'Con huevo frito. Todas nuestras hamburguesas vienen con tocineta, queso mozzarella, queso chédar, pepinillos, cebolla caramelizada, lechuga y tomate.', 18900, 'Sin papas', 9),
(2, 'La Bistec',         'Con huevo frito. Todas nuestras hamburguesas vienen con tocineta, queso mozzarella, queso chédar, pepinillos, cebolla caramelizada, lechuga y tomate.', 24900, 'Con papas', 10),
(2, 'Hamburguesa Smash', 'Pan artesanal de papa, carne de res, tocineta, doble queso mozzarella, cebolla caramelizada en salsa BBQ y miel + salsa de la casa.', 17900, 'Sin papas', 11),
(2, 'Hamburguesa Smash', 'Pan artesanal de papa, carne de res, tocineta, doble queso mozzarella, cebolla caramelizada en salsa BBQ y miel + salsa de la casa.', 23900, 'Con papas', 12);

-- ==========================================================
-- SEED: menu_items — COMIDA MEXICANA (categoría 3)
-- ==========================================================

INSERT INTO menu_items (category_id, name, description, price, price_note, sort_order) VALUES
(3, 'Picada Personal', '400gm de carne de cerdo, chicharrón y pollo + papas a la francesa, ensalada y acompañante de la noche.', 35900, NULL, 1),
(3, 'Quesadillas',     'Tortilla de harina, vegetales salteados, queso mozzarella, pollo desmechado, pico de gallo, maicitos, nachos y guacamole. Opcional jalapeños.', 26900, NULL, 2),
(3, 'Burritos',        'Tortilla de harina, vegetales salteados, queso mozzarella, carne molida, pico de gallo, maicitos, nachos y guacamole. Opcional jalapeños.', 26900, 'Verificar precio', 3);

-- ==========================================================
-- SEED: menu_items — PAPAS BATTIATO (categoría 9)
-- ==========================================================

INSERT INTO menu_items (category_id, name, description, price, sort_order) VALUES
(9, 'Papas Battiato #1', 'Papas a la francesa acompañadas de tocineta, pico de gallo, queso mozzarella y salsa de la casa.', 23900, 1),
(9, 'Papas Battiato #2', 'Papas a la francesa acompañadas de tocineta, pollo desmechado, pico de gallo, queso mozzarella y salsa de la casa.', 24900, 2),
(9, 'Papas Battiato #3', 'Papas a la francesa acompañadas de tocineta, jamón, salchicha ranchera, pico de gallo, queso mozzarella y salsa de la casa.', 24900, 3);

-- ==========================================================
-- SEED: menu_items — PASTAS Y CALZONE (categoría 4)
-- ==========================================================

-- Lasañas (subcategoría 1)
INSERT INTO menu_items (category_id, subcategory_id, name, description, price, price_note, sort_order) VALUES
(4, 1, 'Lasaña Pollo Champiñones', 'Para llevar en aluminio.', 25500, 'Por 450gm', 1),
(4, 1, 'Lasaña Pollo Jamón',       'Para llevar en aluminio.', 25500, 'Por 450gm', 2),
(4, 1, 'Lasaña Pollo Carne',       'Para llevar en aluminio.', 25500, 'Por 450gm', 3),
(4, 1, 'Lasaña Pollo Tocineta',    'Para llevar en aluminio.', 25500, 'Por 450gm', 4),
(4, 1, 'Lasaña Pollo Champiñones', 'Para llevar en aluminio.', 23500, 'Por 370gm', 5),
(4, 1, 'Lasaña Pollo Jamón',       'Para llevar en aluminio.', 23500, 'Por 370gm', 6),
(4, 1, 'Lasaña Pollo Carne',       'Para llevar en aluminio.', 23500, 'Por 370gm', 7),
(4, 1, 'Lasaña Pollo Tocineta',    'Para llevar en aluminio.', 23500, 'Por 370gm', 8);

-- Pastas (subcategoría 2)
INSERT INTO menu_items (category_id, subcategory_id, name, description, price, sort_order) VALUES
(4, 2, 'Pasta Boloñesa',           NULL, 25500, 1),
(4, 2, 'Pasta Carbonara',          NULL, 25500, 2),
(4, 2, 'Pasta Pollo Champiñones',  NULL, 25500, 3),
(4, 2, 'Pasta Alfredo',            NULL, 25500, 4);

-- Calzone (subcategoría 3)
INSERT INTO menu_items (category_id, subcategory_id, name, description, price, sort_order) VALUES
(4, 3, 'Calzone Hawaiano',           'Jamón, queso y piña.',                      25500, 1),
(4, 3, 'Calzone Pollo Jamón',        'Queso, pollo y jamón.',                     25500, 2),
(4, 3, 'Calzone Maíz Tocineta',      'Queso, maíz y tocineta.',                   25500, 3),
(4, 3, 'Calzone Paisa',              'Queso, maíz, tomate y tocineta.',           25500, 4),
(4, 3, 'Calzone Ranchero',           'Queso, salami, jamón y ranchera.',          25500, 5),
(4, 3, 'Calzone Vegetariano',        'Queso, maíz, tomate, cebolla y champiñones.', 25500, 6),
(4, 3, 'Calzone Pollo Champiñones',  'Pollo, queso y champiñones.',               25500, 7);

-- Maicitos (subcategoría 4)
INSERT INTO menu_items (category_id, subcategory_id, name, description, price, sort_order) VALUES
(4, 4, 'Maicitos y queso',                 NULL, 20500, 1),
(4, 4, 'Maicitos, queso y tocineta',       NULL, 22500, 2),
(4, 4, 'Maicitos, queso, pollo y tocineta',NULL, 23500, 3);

-- ==========================================================
-- SEED: menu_items — BEBIDAS (categoría 5)
-- ==========================================================

-- Limonadas (subcategoría 5)
INSERT INTO menu_items (category_id, subcategory_id, name, price, sort_order) VALUES
(5, 5, 'Limonada de verano con vino', 13500, 1),
(5, 5, 'Limonada de coco',             9500, 2),
(5, 5, 'Limonada acerezada',           9500, 3),
(5, 5, 'Limonada natural',             8500, 4),
(5, 5, 'Limonada de hierbabuena',      9500, 5);

-- Jugos (subcategoría 6)
INSERT INTO menu_items (category_id, subcategory_id, name, description, price, sort_order) VALUES
(5, 6, 'Jugo en agua',   'Sabores: mora, mango, guanábana o maracuyá.', 7500, 1),
(5, 6, 'Jugo en leche',  'Sabores: mora, mango, guanábana o maracuyá.', 8500, 2);

-- Sodas Saborizadas (subcategoría 7)
INSERT INTO menu_items (category_id, subcategory_id, name, price, sort_order) VALUES
(5, 7, 'Soda de limón',     9500, 1),
(5, 7, 'Soda de maracuyá',  9500, 2),
(5, 7, 'Soda acerezada',    9500, 3),
(5, 7, 'Soda de lichee',    9500, 4);

-- Guanabanon, bebida original de la casa (subcategoría 8)
INSERT INTO menu_items (category_id, subcategory_id, name, price, sort_order) VALUES
(5, 8, 'Guanabanon de limón',      10500, 1),
(5, 8, 'Guanabanon de maracuyá',   10500, 2),
(5, 8, 'Guanabanon de mango biche',10500, 3);

-- Gaseosas (subcategoría 9)
INSERT INTO menu_items (category_id, subcategory_id, name, price, sort_order) VALUES
(5, 9, 'Gaseosa 350ml',        5500, 1),
(5, 9, 'Gaseosa 237ml',        4000, 2),
(5, 9, 'M Tea',                5500, 3),
(5, 9, 'Soda Hatsu',           5500, 4),
(5, 9, 'Té Hatsu',             6500, 5),
(5, 9, 'Gaseosa familiar',     9000, 6),
(5, 9, 'Gaseosa Hit cajita',   3500, 7),
(5, 9, 'Botella de agua',      4500, 8);

-- ==========================================================
-- SEED: menu_items — BAR (categoría 10)
-- NOTA: "Vaso Michelado" a $1.000 se transcribe tal cual
-- aparece en la carta original; conviene confirmar con el
-- cliente si ese valor es correcto o es un cargo adicional.
-- ==========================================================

-- Cócteles (subcategoría 12) — todos a $16.000
INSERT INTO menu_items (category_id, subcategory_id, name, description, price, sort_order) VALUES
(10, 12, 'Margarita',        'Tequila, limón, jugo de naranja y triple sec.',                        16000, 1),
(10, 12, 'Tequila Sunrise',  'Tequila, limón, jugo de naranja, granadina y cerezas.',                16000, 2),
(10, 12, 'Laguna Azul',      'Vodka, jugo de limón y curazao azul; suave pero de sabor interesante.', 16000, 3),
(10, 12, 'Sexo en la Playa', 'Vodka, jugo de naranja, maracuyá, granadina y cerezas.',               16000, 4),
(10, 12, 'Green Apple',      'Vodka, jugo de naranja, manzana y curazao azul.',                      16000, 5);

-- Cervezas (subcategoría 13)
INSERT INTO menu_items (category_id, subcategory_id, name, price, sort_order) VALUES
(10, 13, 'Pilsen',           6000, 1),
(10, 13, 'Águila Original',  6000, 2),
(10, 13, 'Águila Light',     6000, 3),
(10, 13, 'Poker',            6000, 4),
(10, 13, 'Costeña',          6000, 5),
(10, 13, 'Club Colombia',    7000, 6),
(10, 13, 'Tres Cordilleras', 9500, 7),
(10, 13, 'Corona',           9000, 8),
(10, 13, 'Stella Artois',    9000, 9),
(10, 13, 'Vaso Michelado',   1000, 10);

-- Sangría (subcategoría 14)
INSERT INTO menu_items (category_id, subcategory_id, name, price, price_note, sort_order) VALUES
(10, 14, 'Sangría', 65000, 'Jarra', 1),
(10, 14, 'Sangría', 15000, 'Copa',  2);

-- ==========================================================
-- SEED: menu_items — CAFÉS (categoría 11)
-- ==========================================================

-- Calientes (subcategoría 15)
INSERT INTO menu_items (category_id, subcategory_id, name, price, sort_order) VALUES
(11, 15, 'Cappuccino Amaretto',  8500, 1),
(11, 15, 'Cappuccino sin licor', 6500, 2),
(11, 15, 'Expreso',              4000, 3),
(11, 15, 'Americano',            4500, 4);

-- Fríos (subcategoría 16)
INSERT INTO menu_items (category_id, subcategory_id, name, description, price, sort_order) VALUES
(11, 16, 'Coffee Battiato', 'Rica combinación entre vainilla, amaretto y un poco de helado.',                        12500, 1),
(11, 16, 'Amaretto Frappe', 'Rico y refréscate: en una palabra, perfecto.',                                          9500, 2),
(11, 16, 'Café Mocca',      'El chocolate y el café, siempre buenos amigos; ideal para acompañar una buena comida.', 8500, 3);

-- ==========================================================
-- SEED: pizza_sizes
-- ==========================================================

INSERT INTO pizza_sizes (name, slices, price, sort_order) VALUES
('Personal', NULL, 16900, 1),
('Jumbo',       4, 27500, 2),
('Mediana',     6, 34500, 3),
('Grande',      8, 49000, 4),
('Familiar',   10, 59500, 5);

-- ==========================================================
-- SEED: menu_items — PIZZAS CLÁSICAS (categoría 6)
-- ==========================================================

INSERT INTO menu_items (category_id, name, description, price, sort_order) VALUES
(6, 'Hawaiana',        'Jamón, queso y piña.',                              0, 1),
(6, 'Piña Tocineta',   'Queso, piña y tocineta.',                           0, 2),
(6, 'Ranchera',        'Salami, jamón y salchicha ranchera.',               0, 3),
(6, 'Todas las Carnes','Pollo, jamón, salami, pepperoni y tocineta.',       0, 4),
(6, 'Maíz Tocineta',   'Queso, maíz y tocineta.',                           0, 5),
(6, 'Pollo Jamón',     'Queso, pollo desmechado y jamón.',                  0, 6),
(6, 'Vegetariana',     'Queso, tomate, cebolla salteada y champiñones.',    0, 7),
(6, 'Paisa',           'Tomate, maíz, tocineta y guacamole.',               0, 8);

-- ==========================================================
-- SEED: menu_items — PIZZAS ESPECIALES (categoría 7)
-- ==========================================================

INSERT INTO menu_items (category_id, name, description, price, sort_order) VALUES
(7, 'Napolitana',        'Queso, tomate y albahaca.',                        0, 1),
(7, 'Mixta 1',            'Salami, jamón, cebolla, pimentón y tomate.',      0, 2),
(7, 'Pollo Champiñones',  'Queso, pollo desmechado y champiñones salteados.',0, 3),
(7, 'Florentina',         'Tocineta, aceitunas, pimentón y tomate.',         0, 4),
(7, 'Mixta 2',            'Pollo, tocineta, tomate, cebolla y albahaca.',    0, 5),
(7, 'Tropical',           'Piña, cerezas, ciruelas y manzana verde.',        0, 6);

-- ==========================================================
-- SEED: menu_items — PIZZAS NUEVAS (categoría 8)
-- ==========================================================

INSERT INTO menu_items (category_id, name, description, price, sort_order) VALUES
(8, 'Pizza Portofino',           'Queso mozzarella, champiñones salteados, tomate, tocineta y albahaca.', 0, 1),
(8, 'Pizza Mexicana con Carne',  'Tomate, queso mozzarella, carne a la boloñesa, cebolla, guacamole y jalapeño.', 0, 2),
(8, 'Pizza Cuatro Estaciones',   'Queso mozzarella, tomate, tocineta y albahaca.', 0, 3),
(8, 'Pizza Salvatore',           'Pepperoni, champiñones, queso mozzarella, queso crema y albahaca.', 0, 4),
(8, 'Pizza Bruno',               'Queso mozzarella, tomate, aceitunas, tocineta y pollo.', 0, 5),
(8, 'Pizza Pollo BBQ',           'Queso mozzarella, pollo en salsa BBQ y tocineta.', 0, 6),
(8, 'Pizza Isabella',            'Queso mozzarella, carne a la boloñesa, tocineta y maíz dulce.', 0, 7);

-- NOTA: las pizzas no tienen precio propio (price=0); su precio
-- depende del tamaño elegido, definido en la tabla pizza_sizes.
