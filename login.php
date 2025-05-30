<?php
session_start();
require_once 'includes/config.php';
require_once 'includes/auth_functions.php';

// Si ya está logueado, redirigir al dashboard
if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if (empty($email) || empty($password)) {
        $error = 'Por favor, complete todos los campos.';
    } else {
        try {
            // Verificar conexión
            if (!$pdo) {
                throw new PDOException('No se pudo establecer la conexión a la base de datos.');
            }

            // Iniciar sesión usando la función loginUsuario
            if (loginUsuario($pdo, $email, $password)) {
                // Redirigir al dashboard
                header('Location: dashboard.php');
                exit;
            } else {
                $error = 'Correo electrónico o contraseña incorrectos.';
            }
        } catch (PDOException $e) {
            // Mostrar mensaje de error más detallado
            $error = 'Error de conexión: ' . $e->getMessage();
            error_log('Error de login: ' . $e->getMessage());
        } catch (Exception $e) {
            // Capturar otros tipos de errores
            $error = 'Error inesperado: ' . $e->getMessage();
            error_log('Error inesperado: ' . $e->getMessage());
        }
    }
}
?>

<?php include 'templates/header.php'; ?>

<div class="login-container">
    <div class="login-box">
        <h2>Iniciar Sesión</h2>
        
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label for="email">Correo Electrónico</label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            
            <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
        </form>
        
        <div class="login-links">
            <a href="forgot-password.php">¿Olvidaste tu contraseña?</a>
            <a href="register.php">¿No tienes cuenta? Regístrate</a>
        </div>
    </div>
</div>

<?php include 'templates/footer.php'; ?>