<?php
require_once('pages/model/email_service.php');

$destinatario_prueba = 'basoge1923@nyfhk.com'; // <<<< ¡IMPORTANTE! CAMBIA ESTO A UN CORREO REAL AL QUE TENGAS ACCESO
$asunto_prueba = 'Prueba de Correo GATI - ' . date('Y-m-d H:i:s');
$cuerpo_html_prueba = '<h1>¡Hola desde GATI!</h1><p>Este es un correo de prueba enviado desde tu sistema GATI usando PHPMailer.</p><p>Si lo recibes, ¡todo funciona correctamente!</p>';

echo "Intentando enviar correo de prueba a: " . $destinatario_prueba . "<br>";

if (enviarEmail($destinatario_prueba, $asunto_prueba, $cuerpo_html_prueba)) {
    echo "Correo de prueba enviado exitosamente.<br>";
    echo "Por favor, revisa la bandeja de entrada de " . $destinatario_prueba . " (y la carpeta de spam).<br>";
} else {
    echo "Error al enviar el correo de prueba.<br>";
    echo "Asegúrate de que la configuración en pages/model/email_service.php sea correcta y que la contraseña de aplicación de Gmail esté bien.<br>";
    echo "Si descomentas la línea `// $mail->SMTPDebug = SMTP::DEBUG_SERVER;` en email_service.php, podrás ver más detalles del error.";
}
?>