<?php

declare(strict_types=1);

/*==========================================================
    AUTOLOAD.PHP
    Restaurante Bar Battiato

    Cargador automático de clases (estándar PSR-4, sin Composer).
    El espacio de nombres "Battiato\Menu\MenuItem" se busca en
    el archivo "src/Menu/MenuItem.php".
==========================================================*/

spl_autoload_register(static function (string $className): void {
    $prefix = 'Battiato\\';

    if (strncmp($className, $prefix, strlen($prefix)) !== 0) {
        return;
    }

    $relativeName = substr($className, strlen($prefix));
    $filePath = __DIR__ . '/' . str_replace('\\', '/', $relativeName) . '.php';

    if (is_file($filePath)) {
        require $filePath;
    }
});
