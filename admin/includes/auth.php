<?php
/*==========================================================
    AUTH.PHP
    Restaurante Bar Battiato — Panel de Administración

    Manejo de sesión y verificación de acceso.
==========================================================*/

require_once __DIR__ . '/../../config/database.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * ¿Hay un administrador con sesión iniciada?
 */
function isLoggedIn(): bool
{
    return !empty($_SESSION['admin_id']);
}

/**
 * Corta la ejecución y manda al login si no hay sesión activa.
 * Se llama al principio de cada página del panel (menos login.php).
 */
function requireLogin(): void
{
    if (!isLoggedIn()) {
        header('Location: login.php');
        exit;
    }
}

/**
 * Intenta iniciar sesión. Devuelve true/false.
 */
function attemptLogin(string $username, string $password): bool
{
    $pdo = getDbConnection();

    $stmt = $pdo->prepare('SELECT * FROM admins WHERE username = :username LIMIT 1');
    $stmt->execute(['username' => $username]);
    $admin = $stmt->fetch();

    if ($admin && password_verify($password, $admin['password_hash'])) {
        session_regenerate_id(true);
        $_SESSION['admin_id']       = $admin['id'];
        $_SESSION['admin_username'] = $admin['username'];
        return true;
    }

    return false;
}

function logout(): void
{
    $_SESSION = [];
    session_destroy();
}

/**
 * Genera (o reutiliza) un token CSRF para los formularios del panel.
 */
function csrfToken(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Verifica el token CSRF recibido de un formulario. Corta la
 * ejecución si no coincide.
 */
function verifyCsrfToken(?string $token): void
{
    if (!$token || !hash_equals($_SESSION['csrf_token'] ?? '', $token)) {
        http_response_code(403);
        die('Token de seguridad inválido. Vuelve atrás e intenta de nuevo.');
    }
}
