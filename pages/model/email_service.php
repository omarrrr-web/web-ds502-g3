<?php

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
        
        
        $mail->isSMTP();                                    
        $mail->Host       = 'smtp.gmail.com';           
        $mail->SMTPAuth   = true;                           
        $mail->Username   = 'adansonsilva@gmail.com';     
        $mail->Password   = 'zcsy ndxy voag voxr';               
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;    
        $mail->Port       = 587;                              

        // --- REMITENTE Y DESTINATARIOS ---
        $mail->setFrom('no-reply@gati.com', 'Sistema GATI'); 
        $mail->addAddress($destinatario);                     

        // --- CONTENIDO DEL CORREO ---
        $mail->isHTML(true);                                  
        $mail->Subject = $asunto;
        $mail->Body    = $cuerpoHTML;
        $mail->AltBody = strip_tags($cuerpoHTML); 

        // Enviar el correo
        $mail->send();
        return true;

    } catch (Exception $e) {
        
        return false;
    }
}
?>