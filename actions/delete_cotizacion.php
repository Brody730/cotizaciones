<?php
// Habilitar el reporte de errores para depuración
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Incluir archivos necesarios
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/auth_functions.php';

// Verificar sesión
if (!isset($_SESSION['user_id'])) {
    error_log("Error: Sesión no iniciada");
    header("Location: ../login.php");
    exit;
}

// Verificar permisos
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    error_log("Error: ID inválido o no numérico");
    header("Location: ../dashboard.php");
    exit;
}

try {
    $cotizacion_id = $_GET['id'];
    error_log("Intentando eliminar cotización con ID: " . $cotizacion_id);

    // Verificar que la cotización pertenece al usuario
    $stmt = $pdo->prepare("SELECT * FROM cotizaciones WHERE id = ? AND usuario_id = ?");
    $stmt->execute([$cotizacion_id, $_SESSION['user_id']]);
    $cotizacion = $stmt->fetch();

    if (!$cotizacion) {
        error_log("Error: Cotización no encontrada para ID: " . $cotizacion_id);
        throw new Exception('Cotización no encontrada o no tiene permisos para eliminarla');
    }

    // Eliminar el archivo PDF si existe
    $pdf_path = __DIR__ . '/../logs/' . $cotizacion['pdf_filename'];
    error_log("Ruta del PDF: " . $pdf_path);
    if (file_exists($pdf_path)) {
        if (!unlink($pdf_path)) {
            error_log("Error: No se pudo eliminar el archivo PDF: " . $pdf_path);
            throw new Exception('No se pudo eliminar el archivo PDF');
        }
        error_log("PDF eliminado exitosamente");
    }

    // Eliminar la cotización de la base de datos
    $stmt = $pdo->prepare("DELETE FROM cotizaciones WHERE id = ?");
    $result = $stmt->execute([$cotizacion_id]);
    error_log("Resultado de la eliminación: " . ($result ? "Éxito" : "Fallo"));

    if ($result) {
        error_log("Cotización eliminada exitosamente");
        header("Location: ../dashboard.php?success=1");
        exit;
    } else {
        throw new Exception('Error al eliminar la cotización de la base de datos');
    }

} catch (Exception $e) {
    // Registrar el error
    error_log("Error al eliminar cotización: " . $e->getMessage());
    
    // Mostrar mensaje de error al usuario
    header("Location: ../dashboard.php?error=1");
    exit;
}
