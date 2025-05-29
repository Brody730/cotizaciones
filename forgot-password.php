<?php
include 'includes/config.php';
include 'includes/auth_functions.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $token = generarTokenRecuperacion($pdo, $email);
    
    if(is_string($token)) {
        if(enviarEmailRecuperacion($email, $token)) {
            $_SESSION['mensaje'] = "Se ha enviado un enlace de recuperación a tu correo electrónico";
        } else {
            $_SESSION['error'] = "Error al enviar el correo de recuperación";
        }
    } else {
        $_SESSION['error'] = $token;
    }
    
    header("Location: forgot-password.php");
    exit;
}

include 'templates/header.php';
?>

<div class="container">
    <h2>Recuperar Contraseña</h2>
    
    <?php if(isset($_SESSION['mensaje'])): ?>
        <div class="alert alert-success"><?php echo $_SESSION['mensaje']; unset($_SESSION['mensaje']); ?></div>
    <?php endif; ?>
    
    <?php if(isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>
    
    <form method="post">
        <div class="form-group">
            <label for="email">Correo Electrónico:</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>
        
        <button type="submit" class="btn btn-primary">Enviar Enlace de Recuperación</button>
    </form>
    
    <div class="mt-3">
        <a href="login.php">Volver al Inicio de Sesión</a>
    </div>
</div>

<?php include 'templates/footer.php'; ?>