<?php

declare(strict_types=1);

namespace Battiato\Core;

use PDO;
use PDOException;
use RuntimeException;

/**
 * Administra la conexión PDO a MySQL: una sola conexión compartida por petición.
 *
 * Lee los datos de conexión de las constantes DB_HOST, DB_NAME, DB_USER,
 * DB_PASS y DB_CHARSET que se definen en config/database.php.
 */
final class Database
{
    private static ?PDO $connection = null;

    /**
     * Devuelve la conexión compartida y la crea la primera vez que se pide.
     *
     * @return PDO Conexión lista para usar (errores como excepciones, filas asociativas).
     *
     * @throws RuntimeException Si no se puede conectar con la base de datos.
     *                          El detalle técnico se registra con error_log() y
     *                          no se expone en el mensaje.
     */
    public static function getConnection(): PDO
    {
        if (self::$connection !== null) {
            return self::$connection;
        }

        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET;

        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            self::$connection = new PDO($dsn, DB_USER, DB_PASS, $options);
        } catch (PDOException $exception) {
            error_log('Error de conexión a la base de datos: ' . $exception->getMessage());
            throw new RuntimeException('No se pudo conectar con la base de datos.', 0, $exception);
        }

        return self::$connection;
    }

    /**
     * Reemplaza la conexión compartida. Se usa en las pruebas para inyectar
     * una base de datos en memoria. Con null se reinicia la conexión.
     */
    public static function setConnection(?PDO $connection): void
    {
        self::$connection = $connection;
    }
}
