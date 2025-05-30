<?php
// Habilitar el reporte de errores para depuración
define('DEBUG', true);
if (DEBUG) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}

// Definir constantes para rutas
define('ROOT_PATH', dirname(__DIR__));

// Configuración de la base de datos
define('DB_HOST', 'sql207.infinityfree.com');
define('DB_USER', 'if0_39106407');
define('DB_PASS', 'IMy9MUVigAJMg');
define('DB_NAME', 'if0_39106407_webapp');
define('DB_PORT', 3306);

// Configuración de correo
define('MAIL_HOST', 'smtp.gmail.com');
define('MAIL_USER', 'imbestseth@gmail.com');
define('MAIL_PASS', 'contrasenaperrona170504');
define('MAIL_PORT', 587);

// Configuración adicional para Gmail
define('MAIL_SMTPAUTH', true);
define('MAIL_SMTPSECURE', 'tls');
define('MAIL_DEBUG', 2); // Habilitar modo debug para ver errores

// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Conexión a la base de datos
try {
    $pdo = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("ERROR: No se pudo conectar. " . $e->getMessage());
}

// Incluir FPDF
try {
    require_once(ROOT_PATH . '/libs/fpdf/fpdf.php');
} catch (Exception $e) {
    error_log("Error al cargar FPDF: " . $e->getMessage());
    die("Error: No se pudo cargar la biblioteca FPDF. Por favor, contacte al administrador.");
}
?>