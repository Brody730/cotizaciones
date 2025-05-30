<?php
include 'includes/config.php';
include 'includes/auth_functions.php';

// Verificar sesión
if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include 'templates/header.php';
?>

<div class="container">
    <h2>Solicitar Cotización</h2>
    
    <form action="procesar_cotizacion.php" method="post">
        <div class="form-group">
            <label for="tipo_servicio">Tipo de Servicio:</label>
            <select name="tipo_servicio" id="tipo_servicio" class="form-control" required>
                <option value="">Seleccione...</option>
                <option value="diseno_web">Diseño Web</option>
                <option value="analisis_datos">Análisis de Datos</option>
                <option value="marketing_digital">Marketing Digital</option>
                <option value="desarrollo_app">Desarrollo de Aplicación</option>
            </select>
        </div>
        
        <div class="form-group">
            <label for="complejidad">Nivel de Complejidad:</label>
            <select name="complejidad" id="complejidad" class="form-control" required>
                <option value="">Seleccione...</option>
                <option value="basico">Básico</option>
                <option value="intermedio">Intermedio</option>
                <option value="avanzado">Avanzado</option>
                <option value="personalizado">Personalizado</option>
            </select>
        </div>
        
        <div class="form-group">
            <label for="plazo">Plazo de Entrega:</label>
            <select name="plazo" id="plazo" class="form-control" required>
                <option value="">Seleccione...</option>
                <option value="7">1 semana</option>
                <option value="14">2 semanas</option>
                <option value="30">1 mes</option>
                <option value="60">2 meses</option>
            </select>
        </div>
        
        <div class="form-group">
            <label for="descripcion">Descripción del Proyecto:</label>
            <textarea name="descripcion" id="descripcion" class="form-control" rows="5" required></textarea>
        </div>
        
        <div class="form-group">
            <label for="email">Correo Electrónico:</label>
            <input type="email" name="email" id="email" class="form-control" value="<?php echo $_SESSION['user_email']; ?>" required>
        </div>
        
        <input type="hidden" name="nombre" value="<?php echo htmlspecialchars($_SESSION['user_nombre']); ?>">
        
        <div class="form-actions">
        
        <div class="form-actions">
            <button type="submit" name="accion" value="previsualizar" class="btn btn-info">Previsualizar Cotización</button>
            <button type="submit" name="accion" value="enviar" class="btn btn-primary">Enviar Cotización por Email</button>
        </div>
    </form>
</div>

<?php include 'templates/footer.php'; ?>