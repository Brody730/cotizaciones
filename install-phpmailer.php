<?php
// Script para instalar PHPMailer usando Composer

// Verificar si Composer está instalado
exec('composer --version', $output, $return_var);

if ($return_var !== 0) {
    die("Error: Composer no está instalado. Por favor, instale Composer primero.");
}

// Crear composer.json si no existe
if (!file_exists('composer.json')) {
    $composerJson = [
        "name" => "cotizadorpro/system",
        "require" => [
            "phpmailer/phpmailer" => "^6.8"
        ]
    ];
    
    file_put_contents('composer.json', json_encode($composerJson, JSON_PRETTY_PRINT));
}

// Ejecutar composer install
exec('composer install', $output, $return_var);

if ($return_var === 0) {
    echo "PHPMailer instalado correctamente.\n";
    echo "Las clases de PHPMailer están disponibles en: vendor/phpmailer/phpmailer/src/\n";
} else {
    die("Error al instalar PHPMailer. Mensaje de error: " . implode("\n", $output));
}
?>
