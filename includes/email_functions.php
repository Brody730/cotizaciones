<?php
// Incluir las clases de PHPMailer usando Composer
require_once __DIR__ . '/../vendor/autoload.php';

// Verificar que las clases están disponibles
if (!class_exists('PHPMailer\PHPMailer\PHPMailer')) {
    error_log("Error: PHPMailer no está disponible. Por favor, instale PHPMailer usando Composer.");
    exit("Error: PHPMailer no está disponible. Por favor, ejecute el script install-phpmailer.php para instalar PHPMailer.");
}

// Usar los namespaces de PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function enviarEmailCotizacion($email_destino, $nombre_destino, $pdf_filename) {
    $mail = new PHPMailer(true); // Habilitar excepciones
    
    try {
        // Configuración del servidor SMTP
        $mail->isSMTP();
        $mail->Host = MAIL_HOST;
        $mail->SMTPAuth = MAIL_SMTPAUTH;
        $mail->Username = MAIL_USER;
        $mail->Password = MAIL_PASS;
        $mail->SMTPSecure = MAIL_SMTPSECURE;
        $mail->Port = MAIL_PORT;
        
        // Configuración adicional
        $mail->CharSet = 'UTF-8';
        $mail->SMTPDebug = MAIL_DEBUG; // Habilitar modo debug
        
        // Remitente y destinatario
        $mail->setFrom(MAIL_USER, 'Sistema de Cotizaciones');
        $mail->addAddress($email_destino, $nombre_destino);
        $mail->addReplyTo(MAIL_USER, 'Soporte Técnico');
        
        // Contenido del correo
        $mail->isHTML(true);
        $mail->Subject = 'Tu Cotización de Servicios';
        
        $body = "
            <h2>Estimado/a $nombre_destino,</h2>
            <p>Adjunto encontrarás la cotización solicitada para tu proyecto.</p>
            <p>Si tienes alguna pregunta o necesitas realizar ajustes, no dudes en contactarnos.</p>
            <p>Atentamente,</p>
            <p><strong>Equipo de Servicios Profesionales</strong></p>
        ";
        
        $mail->Body = $body;
        $mail->AltBody = strip_tags($body);
        
        // Agregar archivo adjunto con ruta absoluta
        $mail->addAttachment(ROOT_PATH . '/logs/' . $pdf_filename);
        
        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Error al enviar correo: " . $e->getMessage());
        error_log("Detalles del error: " . $mail->ErrorInfo);
        return false;
    }
}

function enviarEmailRecuperacion($email, $token) {
    $mail = new PHPMailer(true); // Habilitar excepciones
    
    try {
        // Configuración del servidor SMTP
        $mail->isSMTP();
        $mail->Host = MAIL_HOST;
        $mail->SMTPAuth = true;
        $mail->Username = MAIL_USER;
        $mail->Password = MAIL_PASS;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = MAIL_PORT;
        
        // Remitente y destinatario
        $mail->setFrom(MAIL_USER, 'Sistema de Cotizaciones');
        $mail->addAddress($email);
        $mail->addReplyTo(MAIL_USER, 'Soporte Técnico');
        
        // Contenido del correo
        $mail->isHTML(true);
        $mail->Subject = 'Recuperación de Contraseña';
        
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
        
        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Error al enviar correo de recuperación: " . $mail->ErrorInfo);
        return false;
    }
}
?>