# Historias de usuario

Proyecto: sitio web del Restaurante Bar Battiato (PHP + MySQL).
Roles: **Visitante** (cliente que consulta el sitio) y **Administrador** (personal del restaurante que mantiene el menú).

## Visitante

| ID | Historia | Criterios de aceptación | Dónde se implementa |
|---|---|---|---|
| HU-01 | Como visitante, quiero ver la carta organizada por categorías, para encontrar rápido lo que quiero comer o beber. | Puedo cambiar de categoría sin recargar la página; cada categoría muestra la imagen de su carta. | `index.php` (sección Gastronomía), `assets/js/app.js` (pestañas) |
| HU-02 | Como visitante, quiero ver los precios actualizados de cada producto, para decidir mi pedido. | Solo se listan productos visibles; el precio aparece con formato colombiano (`$16.900`). | `includes/menu-data.php` (`renderPriceList`, `formatPrice`) |
| HU-03 | Como visitante, quiero consultar el precio de la pizza según su tamaño, para elegir el tamaño que me conviene. | Se muestran los tamaños activos, con porciones y precio. | `includes/menu-data.php` (`getPizzaSizes`), `index.php` (sección Pizza Plazza) |
| HU-04 | Como visitante, quiero ver fotos del lugar y de los platos, para conocer el ambiente. | Hay un carrusel y puedo ampliar cada foto. | `index.php` (sección galería), `assets/js/app.js` |
| HU-05 | Como visitante, quiero reservar por WhatsApp, para asegurar mi mesa. | El botón abre una conversación de WhatsApp con el restaurante. | `index.php` (sección contacto) |
| HU-06 | Como visitante, quiero ver la ubicación y el horario, para saber cómo llegar. | La dirección y el horario son visibles en la sección de ubicación. | `index.php` (sección ubicación) |
| HU-07 | Como visitante, quiero usar el sitio desde el celular, para consultarlo en cualquier lugar. | Sin desbordes de 320 px a 1920 px; menú hamburguesa en pantallas de hasta 1240 px. | `assets/css/responsive.css` |

## Administrador

| ID | Historia | Criterios de aceptación | Operación CRUD | Dónde se implementa |
|---|---|---|---|---|
| HU-08 | Como administrador, quiero iniciar sesión, para acceder al panel de forma segura. | Con usuario y contraseña válidos entro al panel; sin sesión no puedo ver ninguna página del panel. | — | `admin/login.php`, `admin/includes/auth.php` |
| HU-09 | Como administrador, quiero crear un producto, para agregar platos nuevos a la carta. | El producto queda guardado y aparece en su categoría; el nombre es obligatorio y el precio debe ser un número válido. | **Insertar** | `admin/actions/save-item.php`, `MenuItemRepository::create()` |
| HU-10 | Como administrador, quiero consultar los productos de una categoría, incluidos los ocultos, para saber qué hay en la carta. | El listado muestra nombre, precio y estado (Visible u Oculto). | **Consultar** | `admin/items.php`, `MenuItemRepository::findByCategory()` y `findById()` |
| HU-11 | Como administrador, quiero modificar un producto, para corregir su nombre, descripción o precio. | Los cambios se reflejan de inmediato en el sitio público. | **Actualizar** | `admin/actions/save-item.php`, `MenuItemRepository::update()` |
| HU-12 | Como administrador, quiero eliminar un producto, para quitar platos que ya no se venden. | Se pide confirmación antes de borrar; el producto desaparece del sitio. | **Eliminar** | `admin/actions/delete-item.php`, `MenuItemRepository::delete()` |
| HU-13 | Como administrador, quiero ocultar y volver a mostrar un producto sin borrarlo, para manejar platos de temporada. | Un producto oculto no se ve en el sitio público pero sigue en el panel para reactivarlo. | **Actualizar** | campo `active`, `admin/items.php` |
| HU-14 | Como administrador, quiero actualizar los precios de los tamaños de pizza, para mantener la carta al día. | Los precios se guardan y se reflejan en el sitio. | **Actualizar** | `admin/pizza-sizes.php`, `admin/actions/save-pizza-sizes.php` |
| HU-15 | Como administrador, quiero cerrar sesión, para proteger el panel. | Al salir, la sesión se destruye. | — | `admin/logout.php` |
