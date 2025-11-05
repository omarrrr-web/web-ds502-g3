<?php
// Importar las clases de PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Cargar los archivos de la librería
require 'C:/xampp/htdocs/web-ds502-g3/lib/PHPMailer/Exception.php';
require 'C:/xampp/htdocs/web-ds502-g3/lib/PHPMailer/PHPMailer.php';
require 'C:/xampp/htdocs/web-ds502-g3/lib/PHPMailer/SMTP.php';

/**
 * Función centralizada para enviar correos electrónicos.
 *
 * @param string $destinatario La dirección de correo del destinatario.
 * @param string $asunto El asunto del correo.
 * @param string $cuerpoHTML El contenido del correo en formato HTML.
 * @return bool Devuelve true si el correo se envió correctamente, false en caso contrario.
 */
function enviarEmail($destinatario, $asunto, $cuerpoHTML) {
    // Crear una instancia de PHPMailer
    $mail = new PHPMailer(true);

    try {
        // --- CONFIGURACIÓN DEL SERVIDOR SMTP ---
        // Descomenta la siguiente línea para ver el log de depuración
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;
        
        $mail->isSMTP();                                    // Usar SMTP
        $mail->Host       = 'smtp.gmail.com';             // IMPORTANTE: Cambiar por tu servidor SMTP
        $mail->SMTPAuth   = true;                             // Habilitar autenticación SMTP
        $mail->Username   = 'adansonsilva@gmail.com';       // IMPORTANTE: Tu usuario SMTP (tu correo)
        $mail->Password   = 'zcsy ndxy voag voxr';                // IMPORTANTE: Tu contraseña SMTP o contraseña de aplicación
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;    // Habilitar encriptación TLS
        $mail->Port       = 587;                              // Puerto TCP para TLS (o 465 para SSL)

        // --- REMITENTE Y DESTINATARIOS ---
        $mail->setFrom('no-reply@gati.com', 'Sistema GATI'); // Correo y nombre del remitente
        $mail->addAddress($destinatario);                     // Añadir un destinatario

        // --- CONTENIDO DEL CORREO ---
        $mail->isHTML(true);                                  // Establecer formato de correo a HTML
        $mail->Subject = $asunto;
        $mail->Body    = $cuerpoHTML;
        $mail->AltBody = strip_tags($cuerpoHTML); // Cuerpo alternativo en texto plano para clientes de correo no-HTML

        // Enviar el correo
        $mail->send();
        return true;

    } catch (Exception $e) {
        // En un entorno de producción, deberías registrar este error en lugar de mostrarlo.
        // echo "El mensaje no pudo ser enviado. Mailer Error: {$mail->ErrorInfo}";
        return false;
    }
}
?>