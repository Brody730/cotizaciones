<?php
include 'includes/config.php';
include 'includes/auth_functions.php';
include 'includes/pdf_functions.php';
include 'includes/email_functions.php';

// Verificar sesión
if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recoger datos del formulario
    $tipo_servicio = $_POST['tipo_servicio'];
    $complejidad = $_POST['complejidad'];
    $plazo = $_POST['plazo'];
    $descripcion = $_POST['descripcion'];
    $email = $_POST['email'];
    $nombre_cliente = $_POST['nombre'];
    $accion = $_POST['accion'];
    
    // Validar datos
    if(empty($tipo_servicio) || empty($complejidad) || empty($plazo) || empty($descripcion) || empty($email)) {
        $_SESSION['error'] = "Todos los campos son requeridos";
        header("Location: cotizador.php");
        exit;
    }
    
    // Calcular cotización
    $cotizacion = calcularCotizacion($tipo_servicio, $complejidad, $plazo);
    
    // Generar PDF
    $pdf_filename = generarPDFCotizacion($nombre_cliente, $email, $tipo_servicio, $complejidad, $plazo, $descripcion, $cotizacion);
    
    // Guardar en base de datos
    try {
        $stmt = $pdo->prepare("INSERT INTO cotizaciones (usuario_id, tipo_servicio, complejidad, plazo, descripcion, precio, pdf_filename) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $_SESSION['user_id'],
            $tipo_servicio,
            $complejidad,
            $plazo,
            $descripcion,
            $cotizacion['total'],
            $pdf_filename
        ]);
    } catch(PDOException $e) {
        error_log("Error al guardar cotización: " . $e->getMessage());
    }
    
    if($accion == 'enviar') {
        // Enviar por correo
        if(enviarEmailCotizacion($email, $_SESSION['user_nombre'], $pdf_filename)) {
            $_SESSION['mensaje'] = "Cotización enviada exitosamente a tu correo electrónico";
        } else {
            $_SESSION['error'] = "Error al enviar la cotización por correo";
        }
    } elseif($accion == 'previsualizar') {
        // Previsualización
        header('Content-type: application/pdf');
        header('Content-Disposition: inline; filename="' . $pdf_filename . '"');
        readfile('logs/' . $pdf_filename);
        exit;
    }
    
    header("Location: dashboard.php");
    exit;
}

function calcularCotizacion($tipo, $complejidad, $plazo) {
    // Precios base por tipo de servicio
    $precios_base = [
        'diseno_web' => 500,
        'analisis_datos' => 800,
        'marketing_digital' => 400,
        'desarrollo_app' => 1000
    ];
    
    // Multiplicadores por complejidad
    $multiplicadores = [
        'basico' => 0.8,
        'intermedio' => 1.0,
        'avanzado' => 1.5,
        'personalizado' => 2.0
    ];
    
    // Ajuste por plazo (menos tiempo = más costo)
    $ajuste_plazo = 1 + (30 / $plazo);
    
    $precio = $precios_base[$tipo] * $multiplicadores[$complejidad] * $ajuste_plazo;
    
    return [
        'precio_base' => $precios_base[$tipo],
        'multiplicador_complejidad' => $multiplicadores[$complejidad],
        'ajuste_plazo' => $ajuste_plazo,
        'total' => round($precio, 2)
    ];
}

header("Location: cotizador.php");
exit;
?>