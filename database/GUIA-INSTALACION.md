# Guía de instalación — Restaurante Bar Battiato
### Del cero a tener el sitio funcionando con base de datos

Esta guía asume que **nunca has hecho esto antes**. Vamos a instalar
un programa, copiar archivos, crear una base de datos y probar el
sitio. Sigue los pasos en orden, sin saltarte ninguno.

---

## 0. ¿Qué es lo que vamos a armar?

Hasta ahora tenías un sitio web hecho solo de HTML y CSS: archivos
que el navegador abre directamente y ya. Eso funciona para mostrar
contenido fijo, pero si querías cambiar un precio, tenías que editar
el código.

Ahora el sitio tiene tres piezas que trabajan juntas:

| Pieza | Qué es | Dónde vive |
|---|---|---|
| **MySQL** | La base de datos: una tabla gigante donde se guardan los productos y precios | Dentro de XAMPP |
| **PHP** | El "traductor": lee la base de datos y arma el HTML que ve el visitante | Los archivos `.php` del proyecto |
| **El navegador** | Muestra el resultado final | Chrome, Edge, etc. |

Por eso ya no basta con abrir `index.php` haciendo doble clic — un
archivo `.php` **necesita un servidor** que lo interprete. Ese
servidor (y la base de datos) te los da **XAMPP**.

---

## 1. Instalar XAMPP

1. Entra a **https://www.apachefriends.org**
2. Descarga la versión para tu sistema operativo (Windows, en la
   mayoría de los casos).
3. Ejecuta el instalador. Si Windows te pregunta por antivirus o
   control de cuentas, dale que sí a todo (es normal con XAMPP).
4. Dejar las opciones por defecto está bien. Cuando te pregunte la
   carpeta de instalación, anótala — normalmente es `C:\xampp`.
5. Al terminar, abre el **Panel de Control de XAMPP**
   (XAMPP Control Panel).
6. Verás una lista de módulos (Apache, MySQL, FileZilla, etc.). Dale
   click a **Start** en la fila de **Apache** y en la fila de
   **MySQL**.

Si ambos quedan en verde con la palabra "Running", vas bien.

> **¿Algo no arrancó?** Lo más común es que el puerto 80 (Apache) ya
> esté ocupado por Skype u otro programa. Si te pasa, cuéntame el
> mensaje de error exacto y lo resolvemos.

---

## 2. Copiar el proyecto a la carpeta correcta

XAMPP solo puede mostrar páginas que estén dentro de su carpeta
`htdocs`. Es como el "escritorio público" del servidor.

1. Descomprime el archivo `battiato-web-mysql.zip` que te compartí.
2. Vas a obtener una carpeta llamada `battiato-web1.1`.
3. Copia esa carpeta completa dentro de:

   ```
   C:\xampp\htdocs\
   ```

4. Al final debe quedar así (fíjate que `index.php` esté directo
   adentro, no dentro de una subcarpeta extra):

   ```
   C:\xampp\htdocs\battiato-web1.1\index.php
   C:\xampp\htdocs\battiato-web1.1\admin\
   C:\xampp\htdocs\battiato-web1.1\assets\
   C:\xampp\htdocs\battiato-web1.1\config\
   C:\xampp\htdocs\battiato-web1.1\database\
   C:\xampp\htdocs\battiato-web1.1\includes\
   ```

---

## 3. Crear la base de datos

1. Con Apache y MySQL en verde, abre tu navegador y entra a:

   ```
   http://localhost/phpmyadmin
   ```

   Esto abre **phpMyAdmin**, un panel visual para manejar MySQL sin
   escribir comandos.

2. Arriba vas a ver varias pestañas: Estructura, SQL, Exportar,
   Importar, etc. Click en la pestaña **"SQL"**.

3. Abre el archivo `database/schema.sql` (está dentro de la carpeta
   que copiaste) con el Bloc de Notas, selecciona **todo** el
   contenido (Ctrl+A) y cópialo (Ctrl+C).

4. Pégalo en el cuadro de texto grande que ves en phpMyAdmin.

5. Click en el botón **"Continuar"** (o "Go", según el idioma).

Si todo salió bien, vas a ver una lista de mensajes en verde
confirmando que se crearon las tablas. En el menú de la izquierda ya
debería aparecer una base de datos llamada **`battiato_db`** — si le
das click, vas a ver las tablas: `categories`, `menu_items`,
`pizza_sizes`, etc., ya con datos adentro (los mismos productos y
precios que tenías en las imágenes del menú).

> **¿Te sale un error rojo?** Cópiame el mensaje completo y lo vemos.
> Lo más común es haber copiado el SQL incompleto.

---

## 4. Crear tu usuario para entrar al panel

La base de datos ya tiene los productos, pero todavía no tiene
ningún usuario que pueda administrar el panel. Eso lo creas tú mismo,
una sola vez, así:

1. Abre en el navegador:

   ```
   http://localhost/battiato-web1.1/admin/setup.php
   ```

2. Vas a ver un formulario simple: usuario y contraseña (mínimo 8
   caracteres). Llénalo con lo que tú quieras usar para entrar al
   panel — no tiene que ser el mismo usuario/contraseña de nada más.

3. Click en **"Crear usuario"**.

4. Te va a confirmar que el usuario se creó.

⚠️ **Importante:** este script (`setup.php`) solo debería usarse una
vez. Ve a la carpeta del proyecto y **borra o renombra el archivo
`admin/setup.php`** (por ejemplo, cámbiale el nombre a
`setup.php.bak`). Si lo dejas ahí activo, cualquiera que sepa la URL
podría intentar usarlo — aunque el script se niega a crear un segundo
usuario si ya existe uno, es buena práctica quitarlo del medio.

---

## 5. Entrar al panel de administración

```
http://localhost/battiato-web1.1/admin/login.php
```

Entra con el usuario y contraseña que acabas de crear. Ahí vas a ver:

- Un **dashboard** con las categorías del menú (Burgers, Parrilla,
  Comida Mexicana, Papas Battiato, Pastas y Calzone, Bebidas, Bar,
  Cafés) y de Pizza Plazza.
- Si entras a una categoría, puedes **agregar, editar, ocultar o
  borrar** productos y precios.
- Hay una sección aparte para los **tamaños de pizza** (Personal,
  Jumbo, Mediana, Grande, Familiar).

Prueba cambiar un precio cualquiera y guarda.

---

## 6. Ver el sitio público

```
http://localhost/battiato-web1.1/index.php
```

Navega hasta la sección "Gastronomía" o "Pizza Plazza": debajo de
cada imagen del menú vas a ver una lista de precios en texto. Esa
lista **sí se actualiza** con lo que cambiaste en el panel — recarga
la página después de guardar un cambio y compruébalo.

---

## 7. Actualizar la carta con los precios nuevos (junio 2026)

Si ya tenías el sitio instalado y funcionando de una entrega anterior,
**no vuelvas a correr `database/schema.sql`** — ese archivo intenta
crear las tablas desde cero y falla (o duplica productos) si ya
existen. En su lugar, usa el archivo de migración: agrega solamente
lo nuevo, sin borrar nada de lo que ya tenías.

1. Con Apache y MySQL corriendo, entra a:

   ```
   http://localhost/phpmyadmin
   ```

2. Click en tu base de datos **`battiato_db`** (panel izquierdo),
   luego en la pestaña **"SQL"**.

3. Abre el archivo `database/migracion-2026-06.sql` con el Bloc de
   Notas, copia **todo** su contenido y pégalo en el cuadro de
   phpMyAdmin.

4. Click en **"Continuar"** / **"Go"**.

Esto agrega:

- Las categorías nuevas **Papas Battiato**, **Bar** y **Cafés**.
- Los platos nuevos de **Parrilla** (Especiales de Pollo o Cerdo) y
  las **5 hamburguesas especiales** de la categoría que ahora se
  llama **Burgers** (antes "Fast Food").
- Reordena las pestañas del menú en un orden más lógico.

Después de correrlo, entra a `admin/login.php` y vas a ver las
categorías nuevas en el dashboard, ya con sus productos y precios
cargados. También recarga `index.php` para confirmar que las pestañas
nuevas del menú (Burgers, Papas Battiato, Bar, Cafés) se vean bien.

> **Nota sobre "Vaso Michelado" ($1.000):** ese precio viene tal cual
> en la carta que enviaste. Es un valor bastante más bajo que el
> resto de cervezas, así que probablemente sea un cargo adicional
> (por ejemplo, preparar la michelada de una cerveza ya pedida) y no
> el precio completo de una cerveza. Vale la pena confirmarlo y
> ajustarlo desde el panel si hace falta.

---

## Resumen del flujo (para cuando ya lo tengas instalado)

Cada vez que quieras trabajar en el proyecto:

1. Abre el **Panel de Control de XAMPP**.
2. Dale **Start** a Apache y a MySQL (si no están ya corriendo).
3. Ya puedes abrir `http://localhost/battiato-web1.1/index.php` y
   `http://localhost/battiato-web1.1/admin/login.php` normalmente.

---

## Problemas comunes

**"No se pudo conectar con la base de datos"**
Revisa que MySQL esté en verde en el panel de XAMPP. Si sigue
fallando, abre `config/database.php` y confirma que `DB_NAME` diga
`battiato_db` (el mismo nombre que se creó en el paso 3).

**La página se ve en blanco, o se descarga en vez de mostrarse**
Casi siempre significa que estás abriendo el archivo con doble clic
(`file:///...`) en vez de por `http://localhost/...`. Los archivos
`.php` **necesitan** pasar por Apache — no se pueden abrir
directamente.

**"Ya existe un usuario administrador" en setup.php**
Es normal si ya creaste uno antes. Si olvidaste tu contraseña, entra
a phpMyAdmin → tabla `admins` → puedes borrar la fila y volver a
entrar a `setup.php` para crear uno nuevo.

**Cambié un precio en el panel y no se actualiza en el sitio**
Verifica que estés entrando por `http://localhost/battiato-web1.1/index.php`
(no abriendo el archivo con doble clic) y refresca la página con
Ctrl+F5 para descartar caché del navegador.

**Apache no arranca / puerto ocupado**
Generalmente Skype o algún otro programa está usando el puerto 80.
Cierra ese programa, o cambia el puerto de Apache desde el botón
"Config" en el panel de XAMPP. Si te pasa, dime el mensaje exacto que
te muestra XAMPP y lo resolvemos juntos.

---

Si te trabas en cualquier paso, cuéntame en cuál vas y qué mensaje o
pantalla te sale — con eso te ayudo a resolverlo puntualmente.
