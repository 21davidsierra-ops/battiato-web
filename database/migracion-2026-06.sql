-- ==========================================================
--  MIGRACIÓN — Carta nueva, precios junio 2026
--  Restaurante Bar Battiato
--
--  Este script se ejecuta SOBRE una base de datos battiato_db
--  que ya existe (la que creaste con database/schema.sql).
--  NO borra nada de lo que ya tenías: solo agrega y renombra
--  lo necesario para reflejar la carta nueva.
--
--  Cómo usarlo: phpMyAdmin -> selecciona battiato_db -> pestaña
--  "SQL" -> pega todo este archivo -> Continuar.
-- ==========================================================

USE battiato_db;

-- ----------------------------------------------------------
-- 1. "Fast Food" pasa a llamarse "Burgers" (mismo id=2, mismos
--    productos existentes de Smash, solo cambia nombre/slug).
-- ----------------------------------------------------------

UPDATE categories
   SET name = 'Burgers', slug = 'burgers', sort_order = 1
 WHERE id = 2;

UPDATE categories SET sort_order = 2 WHERE id = 1; -- Parrilla
UPDATE categories SET sort_order = 3 WHERE id = 3; -- Comida Mexicana
UPDATE categories SET sort_order = 5 WHERE id = 4; -- Pastas y Calzone
UPDATE categories SET sort_order = 6 WHERE id = 5; -- Bebidas

-- ----------------------------------------------------------
-- 2. Categorías nuevas: Papas Battiato, Bar, Cafés
-- ----------------------------------------------------------

INSERT INTO categories (id, section, name, slug, icon, sort_order) VALUES
(9,  'restaurante', 'Papas Battiato', 'papas', 'fa-solid fa-utensils',          4),
(10, 'restaurante', 'Bar',            'bar',   'fa-solid fa-beer-mug-empty',    7),
(11, 'restaurante', 'Cafés',          'cafe',  'fa-solid fa-mug-saucer',        8);

-- ----------------------------------------------------------
-- 3. Subcategorías nuevas
-- ----------------------------------------------------------

INSERT INTO subcategories (id, category_id, name, sort_order) VALUES
(10, 1,  'Costichi',                    1),
(11, 1,  'Especiales de Pollo o Cerdo', 2),
(12, 10, 'Cócteles',                    1),
(13, 10, 'Cervezas',                    2),
(14, 10, 'Sangría',                     3),
(15, 11, 'Calientes',                   1),
(16, 11, 'Fríos',                       2);

-- Los 6 productos de Costichi que ya existían quedan agrupados
-- bajo la nueva subcategoría "Costichi" (antes no tenían subcategoría).

UPDATE menu_items
   SET subcategory_id = 10
 WHERE category_id = 1 AND subcategory_id IS NULL;

-- ----------------------------------------------------------
-- 4. Parrilla — Especiales de Pollo o Cerdo (nuevos)
-- ----------------------------------------------------------

INSERT INTO menu_items (category_id, subcategory_id, name, description, price, price_note, sort_order) VALUES
(1, 11, 'BBQ o Champiñones',      'Corte de pechuga de pollo o cerdo de 300gm en la salsa que más te guste.',              31500, 'Sin papas', 1),
(1, 11, 'BBQ o Champiñones',      'Corte de pechuga de pollo o cerdo de 300gm en la salsa que más te guste.',              34900, 'Con papas', 2),
(1, 11, 'Revuelto',               'Tocineta finamente picada, salteada con un poco de maíz tierno y pico de gallo.',       31500, 'Sin papas', 3),
(1, 11, 'Revuelto',               'Tocineta finamente picada, salteada con un poco de maíz tierno y pico de gallo.',       34900, 'Con papas', 4),
(1, 11, 'Mexicano',               'Cualquiera de los dos cortes, con pico de gallo, jalapeños y salsa BBQ.',               31900, 'Sin papas', 5),
(1, 11, 'Mexicano',               'Cualquiera de los dos cortes, con pico de gallo, jalapeños y salsa BBQ.',               34900, 'Con papas', 6),
(1, 11, 'Chuzo de Pollo',         'Chuzo de pollo y tocineta de 250gm, bañado en salsa BBQ.',                              25900, 'Sin papas', 7),
(1, 11, 'Chuzo de Pollo',         'Chuzo de pollo y tocineta de 250gm, bañado en salsa BBQ.',                              28900, 'Con papas', 8),
(1, 11, 'Punta de Anca de Cerdo', 'Corte de 300gm a la plancha en salsa BBQ.',                                             32900, 'Sin papas', 9),
(1, 11, 'Punta de Anca de Cerdo', 'Corte de 300gm a la plancha en salsa BBQ.',                                             35900, 'Con papas', 10);

-- ----------------------------------------------------------
-- 5. Burgers — 5 hamburguesas especiales (nuevas)
--    (la Hamburguesa Smash ya existía; se reordena al final)
-- ----------------------------------------------------------

INSERT INTO menu_items (category_id, name, description, price, price_note, sort_order) VALUES
(2, 'Especial Res',   'Con una carne. Todas nuestras hamburguesas vienen con tocineta, queso mozzarella, queso chédar, pepinillos, cebolla caramelizada, lechuga y tomate.', 18900, 'Sin papas', 1),
(2, 'Especial Res',   'Con una carne. Todas nuestras hamburguesas vienen con tocineta, queso mozzarella, queso chédar, pepinillos, cebolla caramelizada, lechuga y tomate.', 24900, 'Con papas', 2),
(2, 'Especial Pollo', 'Con un filete. Todas nuestras hamburguesas vienen con tocineta, queso mozzarella, queso chédar, pepinillos, cebolla caramelizada, lechuga y tomate.', 18900, 'Sin papas', 3),
(2, 'Especial Pollo', 'Con un filete. Todas nuestras hamburguesas vienen con tocineta, queso mozzarella, queso chédar, pepinillos, cebolla caramelizada, lechuga y tomate.', 24900, 'Con papas', 4),
(2, 'Puerquita',      'Con cerdo en tiras. Todas nuestras hamburguesas vienen con tocineta, queso mozzarella, queso chédar, pepinillos, cebolla caramelizada, lechuga y tomate.', 18900, 'Sin papas', 5),
(2, 'Puerquita',      'Con cerdo en tiras. Todas nuestras hamburguesas vienen con tocineta, queso mozzarella, queso chédar, pepinillos, cebolla caramelizada, lechuga y tomate.', 24900, 'Con papas', 6),
(2, 'Mexicana',       'Guacamole + jalapeño. Todas nuestras hamburguesas vienen con tocineta, queso mozzarella, queso chédar, pepinillos, cebolla caramelizada, lechuga y tomate.', 18900, 'Sin papas', 7),
(2, 'Mexicana',       'Guacamole + jalapeño. Todas nuestras hamburguesas vienen con tocineta, queso mozzarella, queso chédar, pepinillos, cebolla caramelizada, lechuga y tomate.', 24900, 'Con papas', 8),
(2, 'La Bistec',      'Con huevo frito. Todas nuestras hamburguesas vienen con tocineta, queso mozzarella, queso chédar, pepinillos, cebolla caramelizada, lechuga y tomate.', 18900, 'Sin papas', 9),
(2, 'La Bistec',      'Con huevo frito. Todas nuestras hamburguesas vienen con tocineta, queso mozzarella, queso chédar, pepinillos, cebolla caramelizada, lechuga y tomate.', 24900, 'Con papas', 10);

UPDATE menu_items SET sort_order = 11 WHERE category_id = 2 AND name = 'Hamburguesa Smash' AND price_note = 'Sin papas';
UPDATE menu_items SET sort_order = 12 WHERE category_id = 2 AND name = 'Hamburguesa Smash' AND price_note = 'Con papas';

-- ----------------------------------------------------------
-- 6. Papas Battiato (categoría nueva, sin subcategorías)
-- ----------------------------------------------------------

INSERT INTO menu_items (category_id, name, description, price, sort_order) VALUES
(9, 'Papas Battiato #1', 'Papas a la francesa acompañadas de tocineta, pico de gallo, queso mozzarella y salsa de la casa.', 23900, 1),
(9, 'Papas Battiato #2', 'Papas a la francesa acompañadas de tocineta, pollo desmechado, pico de gallo, queso mozzarella y salsa de la casa.', 24900, 2),
(9, 'Papas Battiato #3', 'Papas a la francesa acompañadas de tocineta, jamón, salchicha ranchera, pico de gallo, queso mozzarella y salsa de la casa.', 24900, 3);

-- ----------------------------------------------------------
-- 7. Bar — Cócteles (todos a $16.000)
-- ----------------------------------------------------------

INSERT INTO menu_items (category_id, subcategory_id, name, description, price, sort_order) VALUES
(10, 12, 'Margarita',         'Tequila, limón, jugo de naranja y triple sec.',                        16000, 1),
(10, 12, 'Tequila Sunrise',   'Tequila, limón, jugo de naranja, granadina y cerezas.',                16000, 2),
(10, 12, 'Laguna Azul',       'Vodka, jugo de limón y curazao azul; suave pero de sabor interesante.', 16000, 3),
(10, 12, 'Sexo en la Playa',  'Vodka, jugo de naranja, maracuyá, granadina y cerezas.',               16000, 4),
(10, 12, 'Green Apple',       'Vodka, jugo de naranja, manzana y curazao azul.',                      16000, 5);

-- ----------------------------------------------------------
-- 8. Bar — Cervezas
--    NOTA: "Vaso Michelado" a $1.000 se transcribe tal cual
--    aparece en la carta original; conviene confirmar con el
--    cliente si ese valor es correcto o es un cargo adicional
--    (p. ej. preparar la michelada de una cerveza ya pedida).
-- ----------------------------------------------------------

INSERT INTO menu_items (category_id, subcategory_id, name, price, sort_order) VALUES
(10, 13, 'Pilsen',            6000, 1),
(10, 13, 'Águila Original',   6000, 2),
(10, 13, 'Águila Light',      6000, 3),
(10, 13, 'Poker',             6000, 4),
(10, 13, 'Costeña',           6000, 5),
(10, 13, 'Club Colombia',     7000, 6),
(10, 13, 'Tres Cordilleras',  9500, 7),
(10, 13, 'Corona',            9000, 8),
(10, 13, 'Stella Artois',     9000, 9),
(10, 13, 'Vaso Michelado',    1000, 10);

-- ----------------------------------------------------------
-- 9. Bar — Sangría
-- ----------------------------------------------------------

INSERT INTO menu_items (category_id, subcategory_id, name, price, price_note, sort_order) VALUES
(10, 14, 'Sangría', 65000, 'Jarra', 1),
(10, 14, 'Sangría', 15000, 'Copa',  2);

-- ----------------------------------------------------------
-- 10. Cafés — Calientes
-- ----------------------------------------------------------

INSERT INTO menu_items (category_id, subcategory_id, name, price, sort_order) VALUES
(11, 15, 'Cappuccino Amaretto',  8500, 1),
(11, 15, 'Cappuccino sin licor', 6500, 2),
(11, 15, 'Expreso',              4000, 3),
(11, 15, 'Americano',            4500, 4);

-- ----------------------------------------------------------
-- 11. Cafés — Fríos
-- ----------------------------------------------------------

INSERT INTO menu_items (category_id, subcategory_id, name, description, price, sort_order) VALUES
(11, 16, 'Coffee Battiato', 'Rica combinación entre vainilla, amaretto y un poco de helado.',                          12500, 1),
(11, 16, 'Amaretto Frappe', 'Rico y refréscate: en una palabra, perfecto.',                                            9500, 2),
(11, 16, 'Café Mocca',      'El chocolate y el café, siempre buenos amigos; ideal para acompañar una buena comida.',   8500, 3);

-- ==========================================================
-- Fin de la migración. Verifica en admin/index.php que las
-- nuevas categorías (Papas Battiato, Bar, Cafés) aparezcan,
-- y en el sitio público que las nuevas pestañas del menú
-- muestren los precios correctos.
-- ==========================================================
