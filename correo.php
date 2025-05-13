<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Incluir los archivos de PHPMailer
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

// Recoger los datos del formulario
$name = isset($_POST['name']) ? htmlspecialchars(trim($_POST['name'])) : '';
$email = isset($_POST['email']) ? filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL) : '';
$select = isset($_POST['select']) ? htmlspecialchars(trim($_POST['select'])) : '';
$message = isset($_POST['message']) ? htmlspecialchars(trim($_POST['message'])) : '';

// Validación de los datos
if (empty($name)) {
    die('Name is required');
}
if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die('Valid email is required');
}
if (empty($message)) {
    die('Message is required');
}

    // Configurar el correo
    $mail = new PHPMailer(true);

    try {
        // Configuración del servidor SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Servidor SMTP de Gmail
        $mail->SMTPAuth = true;
        $mail->Username = 'soporte@plastimedia.com'; // Tu dirección de correo
        $mail->Password = 'plasti249'; // Tu contraseña de correo
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Configuración del correo
        $mail->setFrom($email, $name);
        $mail->addAddress('Mrdiaz@arcol.org'); // Dirección de destino
        $mail->addReplyTo($email, $name);

        // Contenido del correo
        $mail->isHTML(true);
        $mail->Subject = "New Message: " . $select;
        $mail->Body = "<p><strong>Nombre:</strong> $name</p>
                       <p><strong>Correo Electrónico:</strong> $email</p>
                       <p><strong>Mensaje:</strong></p>
                       <p>$message</p>";

        $mail->send();
        echo "<script>alert('Gracias por contáctarnos');window.location.href = 'https://amigos.manoamiga.co/';</script>";
    } catch (Exception $e) {
        echo "Failed to send message. Mailer Error: {$mail->ErrorInfo}";
    }
?>
