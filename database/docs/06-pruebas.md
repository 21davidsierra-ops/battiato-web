# Pruebas del módulo

El archivo `tests/run-tests.php` contiene **57 pruebas** que no requieren instalar nada y no tocan tu base de datos MySQL (usan SQLite en memoria).

## Cómo ejecutarlas

Con XAMPP, desde la terminal (en Windows, abre "Shell" en el panel de XAMPP o usa la terminal de la carpeta del proyecto):

```
php tests/run-tests.php
```

Si `php` no se reconoce, usa la ruta completa: `C:\xampp\php\php.exe tests\run-tests.php`.

Termina con "Pruebas fallidas: 0" cuando todo está bien.

## Qué cubren

| Grupo | Qué se prueba | Pruebas |
|---|---|---|
| 1. Carga de clases | Los paquetes `Battiato\Core` y `Battiato\Menu` se cargan solos | 5 |
| 2. `MenuItemValidator` | Casos válidos, vacíos, extremos (150 y 151 caracteres, `ñ`) e inválidos (precio `abc`, negativo, categoría 0) | 17 |
| 3. `MenuItem` | Construcción desde formulario y desde fila de la base de datos, conversión de tipos | 9 |
| 4. `MenuItemRepository` | **Insertar, consultar, actualizar y eliminar**, ordenamiento, ocultos, ids inexistentes y producto sin id | 14 |
| 5. Integración con `menu-data.php` | Formato de precio, consultas del sitio, listas de precios, escape de HTML | 12 |

## Pruebas de integración manual

Además se ejecutaron los scripts reales del panel con peticiones simuladas:

| Escenario | Resultado esperado | Resultado |
|---|---|---|
| Guardar producto válido | Se inserta y se redirige | Correcto |
| Guardar con el mismo id | Se actualiza | Correcto |
| Guardar con precio `abc` | Responde 422 y no guarda | Correcto |
| Guardar sin token CSRF | Responde 403 | Correcto |
| Listar productos | El producto oculto aparece como "Oculto" | Correcto |
| Abrir el formulario de edición | Carga los datos del producto | Correcto |
| Eliminar producto | Se borra el registro | Correcto |
| Página pública completa | Sin errores ni avisos de PHP; no muestra productos ocultos | Correcto |

## Pruebas de pantalla (responsive)

Verificadas con un navegador automatizado en 13 anchos (de 320 px a 1920 px): sin desbordes horizontales, menú de navegación sin texto partido, logo contenido en el header, pestañas y menú hamburguesa funcionando.
