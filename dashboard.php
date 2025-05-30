<?php
// Definir rutas base
$base_path = '/cotizadorpro/'; // Ruta relativa al dominio

// Incluir archivos necesarios
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/auth_functions.php';

// Verificar sesión
if(!isset($_SESSION['user_id'])) {
    header("Location: " . $base_path . 'login.php');
    exit;
}

// Obtener cotizaciones del usuario
$stmt = $pdo->prepare("SELECT * FROM cotizaciones WHERE usuario_id = ? ORDER BY fecha_creacion DESC");
$stmt->execute([$_SESSION['user_id']]);
$cotizaciones = $stmt->fetchAll();

include __DIR__ . '/templates/header.php';
?>

<div class="container">
    <h2>Bienvenido, <?php echo isset($_SESSION['user_nombre']) ? htmlspecialchars($_SESSION['user_nombre']) : 'Usuario'; ?></h2>
    
    <div class="actions mb-4">
        <a href="<?php echo $base_path; ?>cotizador.php" class="btn btn-primary">Nueva Cotización</a>
        <a href="<?php echo $base_path; ?>logout.php" class="btn btn-secondary">Cerrar Sesión</a>
    </div>
    
    <h3>Mis Cotizaciones Recientes</h3>
    
    <?php if(empty($cotizaciones)): ?>
        <div class="alert alert-info">No has generado ninguna cotización aún.</div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Servicio</th>
                        <th>Complejidad</th>
                        <th>Plazo (días)</th>
                        <th>Precio</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($cotizaciones as $cotizacion): ?>
                        <tr>
                            <td><?php echo ucfirst(str_replace('_', ' ', $cotizacion['tipo_servicio'])); ?></td>
                            <td><?php echo ucfirst($cotizacion['complejidad']); ?></td>
                            <td><?php echo $cotizacion['plazo']; ?></td>
                            <td>$<?php echo number_format($cotizacion['precio'], 2); ?></td>
                            <td><?php echo date('d/m/Y', strtotime($cotizacion['fecha_creacion'])); ?></td>
                            <td>
                                <a href="<?php echo $base_path; ?>logs/<?php echo $cotizacion['pdf_filename']; ?>" target="_blank" class="btn btn-sm btn-info">Ver PDF</a>
                                <button onclick="confirmDelete(<?php echo $cotizacion['id']; ?>)" class="btn btn-sm btn-danger">Eliminar</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/templates/footer.php'; ?>

<script>
// Script para confirmar eliminación
function confirmDelete(id) {
    if (confirm('¿Estás seguro de que deseas eliminar esta cotización?')) {
        window.location.href = '<?php echo $base_path; ?>actions/delete_cotizacion.php?id=' + id;
    }
}
</script>