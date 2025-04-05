<?php
include('conection.php');

$mensaje = "";
$tipo = ""; // success, error, warning

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'])) {
    $email = trim($_POST['email']);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $mensaje = "Correo no válido. Introduce un correo válido.";
        $tipo = "warning";
    } else {
        $stmt = $conexion->prepare("SELECT name FROM persona WHERE email = ? LIMIT 1");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $nombre = htmlspecialchars($user['name']);

            $pin = rand(100000, 999999);
            $pin_expires = date("Y-m-d H:i:s", strtotime("+5 minutes"));

            $updateStmt = $conexion->prepare("UPDATE persona SET verification_pin=?, pin_expires=? WHERE email=?");
            $updateStmt->bind_param("sss", $pin, $pin_expires, $email);
            $updateStmt->execute();

            $asunto = 'Verificación de correo';
            $mensajeEmail = "<p>Tu código de verificación es: <strong>{$pin}</strong></p>";
            $headers = "MIME-Version: 1.0\r\nContent-type: text/html; charset=UTF-8\r\nFrom: soporte@bicentenariobolive.com\r\n";

            if (mail($email, $asunto, $mensajeEmail, $headers)) {
                $mensaje = "Código enviado a tu correo.";
                $tipo = "success";
                $redirect = "resetear_contrasenia.php?email=$email";
            } else {
                $mensaje = "Error al enviar el correo.";
                $tipo = "error";
            }
        } else {
            $mensaje = "No se encontró un usuario con este correo.";
            $tipo = "error";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recuperar Contraseña</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" defer></script>
    <style>
      .container {
            max-width: 400px;
            margin: auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Recuperar Contraseña</h2>
        <form method="POST">
            <div class="mb-3">
                <label for="email" class="form-label">Correo Electrónico</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Enviar código</button>
        </form>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let mensaje = "<?php echo $mensaje; ?>";
            let tipo = "<?php echo $tipo; ?>";
            let redirect = "<?php echo isset($redirect) ? $redirect : ''; ?>";

            if (mensaje !== "") {
                Swal.fire({
                    icon: tipo,
                    title: mensaje,
                    confirmButtonText: 'Aceptar'
                }).then(() => {
                    if (redirect) {
                        window.location.href = redirect;
                    }
                });
            }
        });
    </script>

</body>
</html>
