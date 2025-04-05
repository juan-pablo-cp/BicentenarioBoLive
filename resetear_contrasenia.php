<?php
include('conection.php');

if (isset($_POST['pin'], $_POST['password'], $_POST['confirm_password'], $_POST['email'])) {
    $email = $conexion->real_escape_string($_POST['email']);
    $pin = $conexion->real_escape_string($_POST['pin']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    echo "mail <br>";

    // Verificar si el PIN es correcto y no ha expirado
    $query = "SELECT * FROM persona WHERE email='$email' AND verification_pin='$pin' AND pin_expires > NOW() LIMIT 1";
    $result = $conexion->query($query);

    if ($result->num_rows > 0) {
        if ($password === $confirm_password) {
            // Hashear la nueva contraseña
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Actualizar la contraseña y eliminar el PIN
            $update = "UPDATE persona SET password='$hashed_password', verification_pin=NULL, pin_expires=NULL WHERE email='$email'";
            $conexion->query($update);

            echo "<script>
                    alert('Tu contraseña ha sido cambiada correctamente.');
                    window.location.href = 'login.php';
                  </script>";
        } else {
            echo "<script>
                    alert('Las contraseñas no coinciden.');
                    window.location.href = 'resetear_contrasenia.php?email=$email';
                  </script>";
        }
    } else {
        echo "<script>
                alert('Código incorrecto o expirado.');
                window.location.href = 'recuperar.php';
              </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificar Código</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- icono -->
    <script src="https://kit.fontawesome.com/e1d55cc160.js" crossorigin="anonymous"></script>
    <!-- fuente de google Montserrat -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <!-- sweetalert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #f8f9fa;
        }
        .container {
            max-width: 400px;
            margin: auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .password-wrapper {
            position: relative;
        }
        .toggle-password {
            position: absolute;
            right: 10px;
            top: 60%;
            /* transform: translateY(-50%); */
            cursor: pointer;
            color: gray;
        }
        .logo-img{
            height: 80px;
            width: 80px;
            border-radius: 50%;
            margin-right: 10px;
        }
    </style>
    <script>
      function mostrarContraseña(idPassword, idIcon){
          let inputPassword = document.getElementById(idPassword);
          let icon = document.getElementById(idIcon);
          if(inputPassword.type =="password" && icon.classList.contains("fa-eye")){
            inputPassword.type = "text";
            icon.classList.replace("fa-eye","fa-eye-slash");
          }else{
            inputPassword.type = "password";
            icon.classList.replace("fa-eye-slash","fa-eye");
          }
        }
        document.addEventListener('DOMContentLoaded', function() {
          document.getElementById('registerForm').addEventListener('submit', function(e) {
            // Obtener los valores de los campos
            let password = document.getElementById('password').value;
            let password2 = document.getElementById('password2').value;

            // Verificar longitud mínima de contraseña (por ejemplo, 6 caracteres)
            if (password.length < 6) {
              Swal.fire({
                position: "middle",
                icon: "warning",
                title: "la contraseña debe tener al menos 6 caracteres.",
                showConfirmButton: false,
                timer: 2500
              });
                // alert("La contraseña debe tener al menos 6 caracteres.");
                e.preventDefault();
                return;
            }  
            let passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).{6,}$/;
            if (!passwordRegex.test(password)) {
              // alert("La contraseña debe tener al menos 6 caracteres, incluyendo una letra mayúscula, una minúscula,  número y un carácter especial.");
              Swal.fire({
                position: "middle",
                icon: "warning",
                title: "La contraseña debe tener al menos 6 caracteres, incluyendo una letra mayúscula, una minúscula,  número y un carácter especial.",
                showConfirmButton: false,
                timer: 2500
              })
              e.preventDefault();
              return;
            }
            
            // Verificar que las contraseñas coincidan
            if (password !== password2) {
              // alert("Las contraseñas no coinciden.");
              Swal.fire({
                position: "middle",
                icon: "error",
                title: "Las contraseñas no coinciden.",
                showConfirmButton: false,
                timer: 2500
              })
              e.preventDefault();
              return;
            }
          });
        });
       
    </script>
</head>
<body>
    <div class="container mt-5">
      <!-- Logo y Nombre -->
      <div class="text-center">
            <img class="logo-img" src="img/logoBiBoLive.webp" alt="BicentenarioBoLive" width="80">
            <!-- <h3 class="mt-2">Bicentenario BoLive</h3> -->
        </div>
        <br>
        <h2 align='center'>Restablecer Contraseña</h2>
        <form action="resetear_contrasenia.php" method="POST" id="registerForm">
            <input type="hidden" name="email" value="<?= isset($_GET['email']) ? htmlspecialchars($_GET['email']) : '' ?>">
            
            <div class="mb-3">
                <label for="pin" class="form-label">Código de Verificación</label>
                <input type="number" class="form-control" id="pin" name="pin" required>
            </div>
            <div class="mb-3 password-wrapper">
                <label for="password" class="form-label">Nueva Contraseña</label>
                <input type="password" class="form-control" id="password" name="password" required>
                <i id="eyepassword" class="fas fa-eye toggle-password" onclick="mostrarContraseña('password','eyepassword')"></i>
            </div>
            <div class="mb-3 password-wrapper">
                <label for="confirm_password" class="form-label">Confirmar Contraseña</label>
                <input type="password" class="form-control" id="password2" name="confirm_password" required>
                <i id="eyepassword2" class="fas fa-eye toggle-password" onclick="mostrarContraseña('password2','eyepassword2')"></i>
            </div>
            <button type="submit" class="btn btn-primary w-100">Cambiar Contraseña</button>
        </form>
    </div>
</body>
</html>
