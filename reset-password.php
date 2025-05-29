<?php
include 'includes/config.php';
include 'includes/auth_functions.php';

$token = $_GET['token'] ?? '';

if(empty($token)) {
    $_SESSION['error'] = "Token no válido";
    header("Location: login.php");
    exit;
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    
    if($new_password !== $confirm_password) {
        $_SESSION['error'] = "Las contraseñas no coinciden";
    } else {
        $result = cambiarPassword($pdo, $token, $new_password);
        
        if($result === true) {
            $_SESSION['mensaje'] = "Contraseña actualizada correctamente. Ahora puedes iniciar sesión.";
            header("Location: login.php");
            exit;
        } else {
            $_SESSION['error'] = $result;
        }
    }
}

include 'templates/header.php';
?>

<div class="container">
    <h2>Restablecer Contraseña</h2>
    
    <?php if(isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>
    
    <form method="post">
        <div class="form-group">
            <label for="new_password">Nueva Contraseña:</label>
            <input type="password" name="new_password" id="new_password" class="form-control" required minlength="8">
        </div>
        
        <div class="form-group">
            <label for="confirm_password">Confirmar Nueva Contraseña:</label>
            <input type="password" name="confirm_password" id="confirm_password" class="form-control" required minlength="8">
        </div>
        
        <button type="submit" class="btn btn-primary">Restablecer Contraseña</button>
    </form>
</div>

<?php include 'templates/footer.php'; ?>