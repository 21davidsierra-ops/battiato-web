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

// ----- Datos de conexión (ajusta si es necesario) -----

define('DB_HOST', 'localhost');
define('DB_NAME', 'battiato_db');
define('DB_USER', 'root');
define('DB_PASS', '');       // en XAMPP por defecto está vacío
define('DB_CHARSET', 'utf8mb4');

/**
 * Devuelve una conexión PDO reutilizable a la base de datos.
 * Lanza una excepción clara si algo falla, en vez de exponer
 * detalles técnicos al visitante.
 */
function getDbConnection(): PDO
{
    static $pdo = null;

    if ($pdo !== null) {
        return $pdo;
    }

    $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET;

    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    try {
        $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        return $pdo;
    } catch (PDOException $e) {
        // No mostramos el error real al público, solo lo registramos.
        error_log('Error de conexión a la base de datos: ' . $e->getMessage());
        die('No se pudo conectar con la base de datos. Intenta más tarde.');
    }
}
