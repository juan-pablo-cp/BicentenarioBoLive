<?php
include('conection.php');

if(isset($_POST['email']) && isset($_POST['pin'])){
    $email = $_POST['email'];
    $pin   = $_POST['pin'];
    
    // Buscar el usuario con el email y PIN válido (no expirado)
    $query = "SELECT * FROM persona WHERE email = '$email' AND verification_pin = '$pin' AND pin_expires >= NOW()";
    $result = $conexion->query($query) or die($conexion->error);
    
    if($result->num_rows > 0){
        // Si el PIN es correcto, actualizar el estado a verificado
        $conexion->query("UPDATE persona SET verified = 1, verification_pin = NULL, pin_expires = NULL WHERE email = '$email'") or die($conexion->error);
        echo "Tu cuenta ha sido verificada correctamente.";
        echo "<script>
                    alert('cuenta verificada exitosamente.');
                    window.location.href = 'login.php';
              </script>";
    } else 
        echo "El PIN es incorrecto o ha expirado.";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Verificar PIN</title>
  <!-- fuente de google Montserrat -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: Montserrat, Arial, sans-serif;
      background-color: #f4f4f4;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }

    .container {
      background: white;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
      text-align: center;
      width: 100%;
      max-width: 400px;
    }

    h2 {
      color: #333;
      margin-bottom: 20px;
      font-weight: 500;
    }

    label {
      font-weight: 500;
      display: block;
      margin: 10px 0 5px;
      text-align: left;
    }

    input {
      width: 90%;
      padding: 10px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 5px;
      font-size: 16px;
    }

    button {
      width: 100%;
      padding: 10px;
      background-color: #023047;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-size: 16px;
      transition: background 0.3s;
    }

    button:hover {
      background-color: #fb8500;
    }
    .logo-img{
      height: 120px;
      width: 120px;
      border-radius: 50%;
      margin-right: 10px;
    }
  </style>
</head>
<body>
  <div class="container">
    <img src="img/logoBiBoLive.webp" alt="logo" class="logo-img">
    <h2>Verifica tu cuenta con PIN</h2>
    <form action="verify_pin.php" method="POST">
      <label for="email">Correo electrónico:</label>
      <input type="email" name="email" id="email" required>

      <label for="pin">Código PIN:</label>
      <input type="number" name="pin" id="pin" required>

      <button type="submit">Verificar</button>
    </form>
  </div>
</body>
</html>
