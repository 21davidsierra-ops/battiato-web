# Base de datos MySQL — Restaurante Bar Battiato

Esta guía explica cómo poner a correr el sitio con base de datos en tu
propio computador usando **XAMPP**. Si usas WAMP o Laragon los pasos
son prácticamente iguales (cambia dónde está la carpeta `htdocs`/`www`
y cómo abres phpMyAdmin).

## ¿Qué cambió respecto al sitio estático?

- `index.html` ahora es **`index.php`**. El HTML es el mismo, pero
  trae los precios desde MySQL en vez de tenerlos escritos a mano.
- Hay una carpeta nueva **`admin/`**: el panel donde vas a poder
  agregar, editar, ocultar y borrar productos y precios sin tocar
  código.
- Hay una carpeta **`database/`** con el archivo `schema.sql`: crea
  las tablas y las llena con los mismos productos y precios que ya
  tenías en las imágenes del menú, para que el panel arranque
  poblado.
- Hay una carpeta **`config/`** con la conexión a la base de datos, y
  una carpeta **`includes/`** con las funciones que leen el menú.

Las imágenes del menú (parrilla.webp, bebidas.webp, etc.) se siguen
mostrando igual que antes — lo que agrega la base de datos es una
**lista de precios en texto**, debajo de cada imagen, que sí se
actualiza cuando editas algo en el panel.

## ¿Ya tenías el sitio instalado de antes?

Si ya corriste `schema.sql` en una entrega anterior y ahora solo
quieres traer la carta actualizada (Burgers, Papas Battiato, Bar,
Cafés y los precios nuevos), **no vuelvas a correr `schema.sql`**.
Usa en su lugar `database/migracion-2026-06.sql` de la misma forma
(pégalo en la pestaña SQL de phpMyAdmin) — agrega solo lo nuevo, sin
borrar tus datos existentes. El paso a paso completo está en la
sección 7 de `GUIA-INSTALACION.md`.

## Paso 1 — Instalar XAMPP

Descarga XAMPP desde https://www.apachefriends.org e instálalo. Al
terminar, abre el **Panel de Control de XAMPP** e inicia los módulos
**Apache** y **MySQL** (botón "Start" en cada uno).

## Paso 2 — Copiar el proyecto a htdocs

Copia toda la carpeta del proyecto (`battiato-web1.1`, o como la
hayas nombrado) dentro de:

```
C:\xampp\htdocs\
```

Así que te debería quedar, por ejemplo:

```
C:\xampp\htdocs\battiato-web1.1\index.php
C:\xampp\htdocs\battiato-web1.1\admin\
C:\xampp\htdocs\battiato-web1.1\database\
```

## Paso 3 — Crear la base de datos

1. Con Apache y MySQL iniciados, abre en el navegador:
   `http://localhost/phpmyadmin`
2. Click en la pestaña **"SQL"**.
3. Abre el archivo `database/schema.sql` de este proyecto, copia
   **todo** su contenido y pégalo en el cuadro de texto de
   phpMyAdmin.
4. Click en **"Continuar"** / **"Go"**.

Esto crea la base de datos `battiato_db`, sus tablas, y las llena con
los productos y precios actuales del menú.

## Paso 4 — Crear tu usuario del panel

Abre en el navegador:

```
http://localhost/battiato-web1.1/admin/setup.php
```

Completa usuario y contraseña (mínimo 8 caracteres) y da click en
**"Crear usuario"**. Este paso solo se puede hacer una vez — si ya
existe un administrador, el script se niega a crear otro.

**Después de crear tu usuario, borra o renombra `admin/setup.php`**
para que nadie más pueda usarlo.

## Paso 5 — Entrar al panel

```
http://localhost/battiato-web1.1/admin/login.php
```

Desde ahí puedes:

- Ver todas las categorías del menú y de Pizza Plazza.
- Entrar a cada una para agregar, editar, ocultar o borrar productos
  y precios.
- Editar los precios de los tamaños de pizza (Personal, Jumbo,
  Mediana, Grande, Familiar).

## Paso 6 — Ver el sitio público

```
http://localhost/battiato-web1.1/index.php
```

Los cambios que hagas en el panel se ven reflejados de inmediato en
la sección de precios de cada categoría, y en la grilla de tamaños de
Pizza Plazza.

