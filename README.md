# Restaurante Bar Battiato — Sitio web

Sitio web en PHP + MySQL con panel de administración (`/admin`) para gestionar el menú y los precios.

## Puesta en marcha (XAMPP)

1. Copia el proyecto en `htdocs/` (o clona el repositorio allí).
2. Crea tu archivo de conexión a partir del ejemplo:
   ```bash
   cp config/database.example.php config/database.php
   ```
   y ajusta usuario/contraseña si es necesario (en XAMPP: `root` y sin contraseña).
3. En phpMyAdmin, importa `database/schema.sql` (y `database/migracion-2026-06.sql` si aplica).
4. Abre `http://localhost/<carpeta>/admin/setup.php` para crear el primer administrador y **borra ese archivo** después.

Más detalle en [`GUIA-INSTALACION.md`](GUIA-INSTALACION.md).

## Estructura

- `index.php` — sitio público
- `assets/` — CSS, JS e imágenes
- `admin/` — panel de administración
- `includes/` y `config/` — acceso a datos y conexión a MySQL
- `database/` — esquema y migraciones SQL
