<?php
include 'includes/config.php';
include 'includes/auth_functions.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = trim($_POST['nombre']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Validar que las contraseñas coincidan
    if($password !== $confirm_password) {
        $_SESSION['error'] = "Las contraseñas no coinciden";
    } else {
        // Registrar al usuario
        $result = registrarUsuario($pdo, $nombre, $email, $password);
        
        if($result === true) {
            $_SESSION['mensaje'] = "Registro exitoso. Ahora puedes iniciar sesión.";
            header("Location: login.php");
            exit;
        } else {
            $_SESSION['error'] = $result;
        }
    }
}

$page_title = "Registro de Usuario";
include 'templates/header.php';
?>

<div class="auth-form">
    <h2>Registro de Usuario</h2>
    
    <form method="post" id="register-form">
        <div class="form-group">
            <label for="nombre">Nombre Completo:</label>
            <input type="text" name="nombre" id="nombre" class="form-control" required>
        </div>
        
        <div class="form-group">
            <label for="email">Correo Electrónico:</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>
        
        <div class="form-group">
            <label for="password">Contraseña:</label>
            <div style="position: relative;">
                <input type="password" name="password" id="password" class="form-control" required minlength="8">
                <button type="button" class="toggle-password" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer;">
                    <i class="fas fa-eye"></i>
                </button>
            </div>
            <small class="text-muted">Mínimo 8 caracteres</small>
        </div>
        
        <div class="form-group">
            <label for="confirm_password">Confirmar Contraseña:</label>
            <div style="position: relative;">
                <input type="password" name="confirm_password" id="confirm_password" class="form-control" required minlength="8">
                <button type="button" class="toggle-password" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer;">
                    <i class="fas fa-eye"></i>
                </button>
            </div>
        </div>
        
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Registrarse</button>
            <a href="login.php" class="btn btn-secondary">¿Ya tienes cuenta? Inicia Sesión</a>
        </div>
    </form>
</div>

<?php include 'templates/footer.php'; ?>