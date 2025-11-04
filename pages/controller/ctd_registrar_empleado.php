<?php

include "../template/loadclass.php";

if (isset($_POST["btn_registrar"])) {
    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $email = $_POST["email"];
    $password = $_POST["password"]; 
    $id_rol = $_POST["id_rol"];

    $crud = new CRUDEmpleado();
    $crud->RegistrarEmpleado($nombre, $apellido, $email, $password, $id_rol);

    // --- INICIO: Implementación de envío de correo ---
    require_once('../model/email_service.php');

    $asunto = "¡Bienvenido a Consultoría Ágil S.A.!";
    $cuerpoHTML = "
        <html>
            <body style='background: #f9fafc; font-family: Arial, sans-serif; color: #2d2d2d; margin:0; padding:0;'>
                <table style='max-width: 500px; margin: 40px auto; background: #fff; border-radius: 8px; box-shadow: 0 4px 24px rgba(0,0,0,0.07);'>
                    <tr>
                        <td style='padding: 24px 32px 16px 32px; border-bottom: 2px solid #17a2b8;'>
                            <h2 style='margin:0; color:#17a2b8; font-weight:700;'>¡Bienvenido a Consultoría Ágil S.A.!</h2>
                        </td>
                    </tr>
                    <tr>
                        <td style='padding: 28px 32px;'>
                            <p style='margin:0 0 14px 0;'>Hola <span style='font-weight: bold;'>" . htmlspecialchars($nombre) . "</span>,</p>
                            <p style='margin:0 0 16px 0;'>Tu cuenta ha sido creada exitosamente en nuestro <strong>Sistema de Gestión de Activos de T.I. (GATI)</strong>.</p>
                            <div style='background:#f1f3f8; border-radius:6px; padding:20px; margin-bottom:20px;'>
                                <p style='margin: 0 0 16px 0;'><strong>Tus credenciales de acceso iniciales son:</strong></p>
                                <ul style='padding-left:18px; margin:0;'>
                                    <li><strong>Usuario:</strong> " . htmlspecialchars($email) . "</li>
                                    <li><strong>Contraseña:</strong> La que elegiste durante el registro.</li>
                                </ul>
                            </div>
                            <p style='margin-bottom: 16px;'>Te recomendamos guardar este correo para futuras referencias.</p>
                            <hr style='border:none; border-top:1px solid #eee; margin:24px 0;'>
                            <p>Saludos cordiales,<br>
                            <strong>El equipo de T.I. de Consultoría Ágil S.A.</strong></p>
                        </td>
                    </tr>
                    <tr>
                        <td style='padding: 16px 32px; background:#f6fafb; text-align:center; font-size:12px; color:#7a7a7a; border-radius:0 0 8px 8px;'>
                            © 2025 Consultoría Ágil S.A. — Todos los derechos reservados.
                        </td>
                    </tr>
                </table>
            </body>
        </html>
        ";

    // Intentar enviar el correo y determinar el parámetro para la URL
    if (enviarEmail($email, $asunto, $cuerpoHTML)) {
        $estadoEmail = 'enviado';
    } else {
        $estadoEmail = 'fallo';
    }
    // --- FIN: Implementación de envío de correo ---

    // Redirigir de vuelta a la lista con un parámetro de éxito y el estado del email
    header("location: ../view/empleado/listar.php?registro=exito&email=" . $estadoEmail);
}

?>