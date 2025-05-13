<?php
header("Content-Type: application/json");

// Recibir datos del JSON
$data = json_decode(file_get_contents("php://input"), true);

if ($data) {
    // Extraer datos
    $nombre = $data["nombre"] ?? null;
    $apellidos = $data["apellidos"] ?? null;
    $correo = $data["correo"] ?? null;
    $telefono = $data["telefono"] ?? null;
    $tipo_documento = $data["tipo_documento"] ?? null;
    $documento = $data["documento"] ?? null;
    $donacion = $data["donacion"] ?? null;
    $tipo_cuenta = $data["tipo_cuenta"] ?? null;
    $banco = $data["banco"] ?? null;
    $numero_cuenta = $data["numero_cuenta"] ?? null;
    $fecha_tarjeta = $data["fecha_tarjeta"] ?? null;

    // Validar que no haya datos vacíos
    if (!$nombre || !$apellidos || !$correo || !$telefono || !$tipo_documento || !$documento || !$donacion || !$tipo_cuenta || !$banco || !$numero_cuenta || !$fecha_tarjeta) {
        echo json_encode(["status" => false, "message" => "Faltan datos obligatorios"]);
        exit;
    }

    // Configurar el mensaje del correo
    $to = "tucorreo@example.com";  // Reemplázalo con tu correo
    $subject = "Nueva Donación Recurrente";
    $message = "Nueva donación recurrente:\n\n";
    $message .= "Nombre: $nombre $apellidos\n";
    $message .= "Correo: $correo\n";
    $message .= "Teléfono: $telefono\n";
    $message .= "Tipo de Documento: $tipo_documento\n";
    $message .= "Número de Documento: $documento\n";
    $message .= "Monto de Donación: $donacion\n";
    $message .= "Tipo de Cuenta: $tipo_cuenta\n";
    $message .= "Banco: $banco\n";
    $message .= "Número de Cuenta/Tarjeta: $numero_cuenta\n";
    $message .= "Fecha de Vencimiento: $fecha_tarjeta\n";

    $headers = "From: soporte@plastimedia.com";  // Cambia esto según tu configuración

    // Enviar correo
    if (mail($to, $subject, $message, $headers)) {
        echo json_encode(["status" => true, "message" => "Correo enviado correctamente"]);
    } else {
        echo json_encode(["status" => false, "message" => "Error al enviar el correo"]);
    }
} else {
    echo json_encode(["status" => false, "message" => "Datos no recibidos correctamente"]);
}
?>
