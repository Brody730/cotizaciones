<?php
function enviarEmailCotizacion($email_destino, $nombre_destino, $pdf_filename) {
    require_once 'PHPMailer/PHPMailerAutoload.php';
    
    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->Host = MAIL_HOST;
    $mail->SMTPAuth = true;
    $mail->Username = MAIL_USER;
    $mail->Password = MAIL_PASS;
    $mail->SMTPSecure = 'tls';
    $mail->Port = MAIL_PORT;
    
    $mail->setFrom(MAIL_USER, 'Sistema de Cotizaciones');
    $mail->addAddress($email_destino, $nombre_destino);
    $mail->addReplyTo(MAIL_USER, 'Soporte Técnico');
    
    $mail->isHTML(true);
    $mail->Subject = 'Tu Cotizacion de Servicios';
    
    $body = "
        <h2>Estimado/a $nombre_destino,</h2>
        <p>Adjunto encontrarás la cotización solicitada para tu proyecto.</p>
        <p>Si tienes alguna pregunta o necesitas realizar ajustes, no dudes en contactarnos.</p>
        <p>Atentamente,</p>
        <p><strong>Equipo de Servicios Profesionales</strong></p>
    ";
    
    $mail->Body = $body;
    $mail->AltBody = strip_tags($body);
    $mail->addAttachment('logs/' . $pdf_filename);
    
    if(!$mail->send()) {
        error_log("Error al enviar correo: " . $mail->ErrorInfo);
        return false;
    }
    
    return true;
}

function enviarEmailRecuperacion($email, $token) {
    require_once 'PHPMailer/PHPMailerAutoload.php';
    
    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->Host = MAIL_HOST;
    $mail->SMTPAuth = true;
    $mail->Username = MAIL_USER;
    $mail->Password = MAIL_PASS;
    $mail->SMTPSecure = 'tls';
    $mail->Port = MAIL_PORT;
    
    $mail->setFrom(MAIL_USER, 'Sistema de Cotizaciones');
    $mail->addAddress($email);
    $mail->addReplyTo(MAIL_USER, 'Soporte Técnico');
    
    $mail->isHTML(true);
    $mail->Subject = 'Recuperacion de Contrasena';
    
    $reset_link = "http://" . $_SERVER['HTTP_HOST'] . "/reset-password.php?token=" . $token;
    
    $body = "
        <h2>Solicitud de Recuperación de Contraseña</h2>
        <p>Hemos recibido una solicitud para restablecer tu contraseña. Si no realizaste esta solicitud, puedes ignorar este correo.</p>
        <p>Para establecer una nueva contraseña, haz clic en el siguiente enlace:</p>
        <p><a href='$reset_link'>$reset_link</a></p>
        <p>Este enlace expirará en 1 hora.</p>
    ";
    
    $mail->Body = $body;
    $mail->AltBody = strip_tags($body);
    
    if(!$mail->send()) {
        error_log("Error al enviar correo de recuperación: " . $mail->ErrorInfo);
        return false;
    }
    
    return true;
}
?>