# Tutorial: Implementación de Notificaciones por Correo desde Cero

Esta guía explica, paso a paso, cómo configurar y utilizar el servicio de envío de correos en el proyecto GATI utilizando la librería PHPMailer.

---

### **Sección 1: Configuración Inicial**

#### **Paso 1.1: Descargar la Librería PHPMailer**

1.  Ve a la página oficial de PHPMailer en GitHub: [https://github.com/PHPMailer/PHPMailer](https://github.com/PHPMailer/PHPMailer)
2.  Haz clic en el botón verde **`< > Code`** y luego en **`Download ZIP`**.
3.  Guarda y descomprime el archivo ZIP en tu computadora.

#### **Paso 1.2: Integrar PHPMailer al Proyecto**

1.  En la raíz de tu proyecto (`C:\xampp\htdocs\web-ds502-g3\`), crea una nueva carpeta llamada `lib`.
2.  Dentro de `lib`, crea otra carpeta llamada `PHPMailer`.
3.  Abre la carpeta que descomprimiste (`PHPMailer-master`) y entra a la subcarpeta `src`.
4.  Copia todos los archivos de `src` (Exception.php, PHPMailer.php, SMTP.php) y pégalos en tu nueva carpeta `lib/PHPMailer/`.

    La estructura final debe ser:
    ```
    web-ds502-g3/
    ├── lib/
    │   └── PHPMailer/
    │       ├── Exception.php
    │       ├── PHPMailer.php
    │       └── SMTP.php
    └── ... (resto de tus carpetas)
    ```

#### **Paso 1.3: Generar una Contraseña de Aplicación en Gmail**

Por seguridad, no puedes usar tu contraseña normal de Gmail. Debes generar una contraseña especial para que GATI pueda usar tu cuenta.

1.  **Activa la Verificación en dos pasos:** Si no la tienes activa, ve a la configuración de seguridad de tu cuenta de Google y actívala. Es un requisito indispensable.
2.  **Ve a Contraseñas de aplicaciones:** En la misma sección de Seguridad, busca y haz clic en "Contraseñas de aplicaciones".
3.  **Genera la contraseña:**
    *   En "Seleccionar aplicación", elige "Otra (nombre personalizado)".
    *   Escribe un nombre descriptivo, como `Sistema GATI`.
    *   Haz clic en "Generar".
4.  **Copia la contraseña:** Google te mostrará una contraseña de 16 letras en un recuadro amarillo. **Cópiala y guárdala bien.** Esta es la contraseña que usarás en el siguiente paso.

#### **Paso 1.4: Crear el Servicio de Correo Centralizado**

Para no repetir la configuración, crearemos un único archivo que se encargue de todo el proceso de envío.

1.  Crea un nuevo archivo en `pages/model/` llamado `email_service.php`.
2.  Pega el siguiente código en ese archivo:

    ```php
    <?php
    // Importar las clases de PHPMailer
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    // Cargar los archivos de la librería (usando la ruta absoluta del proyecto)
    require_once __DIR__ . '/../../lib/PHPMailer/Exception.php';
    require_once __DIR__ . '/../../lib/PHPMailer/PHPMailer.php';
    require_once __DIR__ . '/../../lib/PHPMailer/SMTP.php';

    function enviarEmail($destinatario, $asunto, $cuerpoHTML) {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'tu_correo@gmail.com';         // <<== CAMBIA ESTO
            $mail->Password   = 'xxxx xxxx xxxx xxxx';         // <<== CAMBIA ESTO por tu contraseña de aplicación
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            $mail->setFrom('no-reply@gati.com', 'Sistema GATI');
            $mail->addAddress($destinatario);

            $mail->isHTML(true);
            $mail->Subject = $asunto;
            $mail->Body    = $cuerpoHTML;
            $mail->AltBody = strip_tags($cuerpoHTML);

            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
    ?>
    ```

3.  **¡MUY IMPORTANTE!** Modifica las siguientes líneas en el código que acabas de pegar:
    *   `$mail->Username`: Cambia `'tu_correo@gmail.com'` por tu dirección de correo de Gmail.
    *   `$mail->Password`: Cambia `'xxxx xxxx xxxx xxxx'` por la contraseña de aplicación de 16 letras que generaste en el paso anterior.

---

### **Sección 2: Implementación en el Código**

Ahora que todo está configurado, vamos a usar nuestro servicio para enviar un correo de bienvenida cuando se registra un nuevo empleado.

1.  Abre el archivo `pages/controller/ctd_registrar_empleado.php`.
2.  Reemplaza todo el contenido de ese archivo con el siguiente código, que ya incluye la lógica de envío:

    ```php
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

        // Incluimos nuestro servicio de correo
        require_once('../model/email_service.php');

        // Preparamos el contenido del correo
        $asunto = "¡Bienvenido a Consultoría Ágil S.A.!";
        $cuerpoHTML = "<h2>Hola " . htmlspecialchars($nombre) . ",</h2><p>Tu cuenta ha sido creada en el sistema GATI.</p>";

        // Llamamos a la función para enviar el correo
        enviarEmail($email, $asunto, $cuerpoHTML);

        // Redirigimos al usuario
        header("location: ../view/empleado/listar.php?registro=exito");
    }

    ?>
    ```

---

### **Sección 3: Prueba Final**

1.  Abre el sistema GATI en tu navegador.
2.  Ve a la sección de empleados y registra un nuevo empleado con una dirección de correo electrónico real a la que tengas acceso.
3.  Completa el registro.
4.  Revisa la bandeja de entrada (y la carpeta de spam) del correo que registraste.

Si el correo de bienvenida llegó, ¡felicidades! Has implementado exitosamente las notificaciones por correo en el proyecto.
