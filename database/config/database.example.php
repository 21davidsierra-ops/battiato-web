<?php
/*==========================================================
    DATABASE.PHP
    Restaurante Bar Battiato

    Conexión a MySQL usando PDO. Este archivo lo incluyen
    tanto el sitio público (index.php) como el panel de
    administración (admin/*.php).

    ARCHIVO DE EJEMPLO (este sí se sube al repositorio).
    Cópialo como config/database.php y ajusta tus datos reales:
        cp config/database.example.php config/database.php
    El config/database.php real NO se sube a Git (ver .gitignore).

    Para producción (hosting compartido), usa los valores que te
    dé tu proveedor de hosting.
==========================================================*/

require_once __DIR__ . '/../src/autoload.php';

use Battiato\Core\Database;

// ----- Datos de conexión (ajusta si es necesario) -----

define('DB_HOST', 'localhost');
define('DB_NAME', 'battiato_db');
define('DB_USER', 'root');
define('DB_PASS', '');       // en XAMPP por defecto está vacío
define('DB_CHARSET', 'utf8mb4');

/**
 * Devuelve la conexión PDO compartida a la base de datos.
 *
 * Es un atajo de Battiato\Core\Database::getConnection(). Si no se puede
 * conectar, termina la página con un mensaje genérico para el visitante
 * (el detalle técnico queda registrado con error_log()).
 */
function getDbConnection(): PDO
{
    try {
        return Database::getConnection();
    } catch (RuntimeException $exception) {
        die('No se pudo conectar con la base de datos. Intenta más tarde.');
    }
}
