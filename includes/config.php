<?php
// Configuración de la base de datos
define('DB_HOST', 'sql207.infinityfree.com');
define('DB_USER', 'if0_39106407');
define('DB_PASS', 'IMy9MUVigAJMg');
define('DB_NAME', 'if0_39106407_webapp');
define('DB_PORT', 3306);

// Configuración de correo
define('MAIL_HOST', 'smtp.example.com');
define('MAIL_USER', 'correo@example.com');
define('MAIL_PASS', 'password');
define('MAIL_PORT', 587);

// Iniciar sesión
session_start();

// Conexión a la base de datos
try {
    $pdo = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("ERROR: No se pudo conectar. " . $e->getMessage());
}

// Incluir FPDF
require_once('libs/fpdf/fpdf.php');
?>