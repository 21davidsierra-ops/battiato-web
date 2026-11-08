# Documentación del proyecto — Restaurante Bar Battiato

Evidencia **GA7-220501096-AA2-EV01 — Codificación de módulos del software**.

Módulo codificado: **Gestión del menú** (productos de la carta), con las cuatro operaciones: insertar, consultar, actualizar y eliminar.

## Artefactos del ciclo del software

| Artefacto | Archivo |
|---|---|
| Historias de usuario | [01-historias-de-usuario.md](01-historias-de-usuario.md) |
| Diagrama y especificación de casos de uso | [02-casos-de-uso.md](02-casos-de-uso.md) |
| Diagrama de clases y arquitectura | [03-diagrama-de-clases.md](03-diagrama-de-clases.md) |
| Modelo de datos (entidad-relación) | [04-modelo-de-datos.md](04-modelo-de-datos.md) |
| Estándares de codificación | [05-estandares-de-codificacion.md](05-estandares-de-codificacion.md) |
| Pruebas | [06-pruebas.md](06-pruebas.md) |
| Prototipos, diseños e informe técnico del plan de trabajo (de evidencias anteriores) | carpeta [artefactos-previos](artefactos-previos/) |

Los diagramas están escritos en Mermaid: GitHub y GitLab los muestran como dibujos al abrir cada archivo.

## Cumplimiento de los requisitos de la evidencia

| Requisito | Cómo se cumple |
|---|---|
| Tener en cuenta los artefactos del ciclo del software | Las historias de usuario, los casos de uso, el diagrama de clases y el modelo de datos de esta carpeta describen exactamente el código entregado. |
| Crear el proyecto con herramientas de versionamiento | Repositorio Git en GitHub y GitLab (enlaces en `ENLACE_REPOSITORIO.txt`). |
| Estándares de codificación: variables, métodos, clases y paquetes | [05-estandares-de-codificacion.md](05-estandares-de-codificacion.md). Paquetes `Battiato\Core` y `Battiato\Menu` en `src/`. |
| **Insertar** | `MenuItemRepository::create()`, usado por `admin/actions/save-item.php` |
| **Consultar** | `MenuItemRepository::findById()` y `findByCategory()`, usados por `admin/items.php` y `includes/menu-data.php` |
| **Actualizar** | `MenuItemRepository::update()`, usado por `admin/actions/save-item.php` |
| **Eliminar** | `MenuItemRepository::delete()`, usado por `admin/actions/delete-item.php` |
| Comprobar que el módulo funciona | `php tests/run-tests.php` → 57 pruebas ([06-pruebas.md](06-pruebas.md)) |

## Estructura del código

```
src/
  autoload.php               cargador automático de clases (PSR-4)
  Core/Database.php          paquete Battiato\Core: conexión a MySQL
  Menu/MenuItem.php          paquete Battiato\Menu: entidad producto
  Menu/MenuItemValidator.php                         validación de datos
  Menu/MenuItemRepository.php                        CRUD en la base de datos
admin/                       panel de administración
includes/menu-data.php       consultas y listas de precios del sitio
tests/run-tests.php          pruebas del módulo
```
