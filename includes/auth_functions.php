<?php
function registrarUsuario($pdo, $nombre, $email, $password) {
    // Verificar si el email ya existe
    $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    
    if($stmt->rowCount() > 0) {
        return "El correo electrónico ya está registrado";
    }
    
    // Hash de la contraseña
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
    // Insertar nuevo usuario
    $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, email, password) VALUES (?, ?, ?)");
    if($stmt->execute([$nombre, $email, $hashedPassword])) {
        return true;
    }
    return "Error al registrar el usuario";
}

function loginUsuario($pdo, $email, $password) {
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    
    if($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_nombre'] = $user['nombre'];
        return true;
    }
    return "Credenciales incorrectas";
}

function generarTokenRecuperacion($pdo, $email) {
    try {
        // Verificar si el email existe
        $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        $usuario = $stmt->fetch();
        
        if(!$usuario) {
            return "El correo electrónico no está registrado";
        }
        
        // Generar token único
        $token = bin2hex(random_bytes(32));
        $expiracion = date('Y-m-d H:i:s', strtotime('+1 hour'));
        
        // Insertar token en la tabla tokens_recuperacion
        $stmt = $pdo->prepare("INSERT INTO tokens_recuperacion (usuario_id, token, expiracion) VALUES (?, ?, ?)");
        $stmt->execute([$usuario['id'], $token, $expiracion]);
        
        return $token;
    } catch(PDOException $e) {
        error_log("Error en generarTokenRecuperacion: " . $e->getMessage());
        return "Error al generar el token";
    }
}

function cambiarPassword($pdo, $token, $newPassword) {
    // Verificar token válido y no expirado
    $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE reset_token = ? AND reset_expira > NOW()");
    $stmt->execute([$token]);
    
    if($stmt->rowCount() == 0) {
        return "Token inválido o expirado";
    }
    
    $user = $stmt->fetch();
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    
    // Actualizar contraseña y limpiar token
    $stmt = $pdo->prepare("UPDATE usuarios SET password = ?, reset_token = NULL, reset_expira = NULL WHERE id = ?");
    if($stmt->execute([$hashedPassword, $user['id']])) {
        return true;
    }
    return "Error al actualizar la contraseña";
}
?>