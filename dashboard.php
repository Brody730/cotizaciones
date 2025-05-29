<?php
include 'includes/config.php';
include 'includes/auth_functions.php';

// Verificar sesión
if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Obtener cotizaciones del usuario
$stmt = $pdo->prepare("SELECT * FROM cotizaciones WHERE usuario_id = ? ORDER BY fecha_creacion DESC");
$stmt->execute([$_SESSION['user_id']]);
$cotizaciones = $stmt->fetchAll();

include 'templates/header.php';
?>

<div class="container">
    <h2>Bienvenido, <?php echo htmlspecialchars($_SESSION['user_nombre']); ?></h2>
    
    <div class="actions mb-4">
        <a href="cotizador.php" class="btn btn-primary">Nueva Cotización</a>
        <a href="logout.php" class="btn btn-secondary">Cerrar Sesión</a>
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
                                <a href="logs/<?php echo $cotizacion['pdf_filename']; ?>" target="_blank" class="btn btn-sm btn-info">Ver PDF</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php include 'templates/footer.php'; ?>