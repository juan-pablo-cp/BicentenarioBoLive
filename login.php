<?php
session_start();
include('conection.php');

if(isset($_POST['correo']) && isset($_POST['password'])) {
  $email = $conexion->real_escape_string($_POST['correo']);
  $password = $_POST['password'];

  // Consulta para buscar el usuario con ese correo
  $query = "SELECT * FROM persona WHERE email='$email' LIMIT 1";
  $result = $conexion->query($query) or die($conexion->error);

  if($result->num_rows > 0) {
      $user = $result->fetch_assoc();
      
      // Verifica si la cuenta está verificada (si usas ese campo) si o no 
      if($user['verified'] != 'si') {
        // echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
          echo "<script>
                  if (confirm('Cuenta no verificada. ¿Deseas verificar ahora?')) {
                    window.location.href = 'verify_pin.php';
                  } else {
                    window.location.href = 'index.php';
                  }
                </script>";
          exit;
      }
      
      // Verifica la contraseña usando password_verify
      if(password_verify($password, $user['password'])) {
          // Las credenciales son correctas. Inicia la sesión.
          $_SESSION['user_id'] = $user['id'];
          $_SESSION['user_name'] = $user['name'];
          // Redireccionar a la página protegida (home.php, por ejemplo)
          header("Location: home.php");
          exit;
      } else {
          // La contraseña es incorrecta
          echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
          echo "<script>
                  Swal.fire({
                    position: 'middle',
                    icon: 'warning',
                    title: 'contraseña incorrecta',
                    showConfirmButton: false,
                    timer: 1500
                  }).then(() => {
                    window.location.href = 'login.php';
                  });
                </script>";
          exit;
      }
  } else {
      // No se encontró el usuario
      echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
      echo "<script>
              Swal.fire({
                    position: 'middle',
                    icon: 'error',
                    title: 'No existe una cuenta con este correo.',
                    showConfirmButton: false,
                    timer: 1500
                  }).then(() => {
                    window.location.href = 'login.php';
                  });
            </script>";
      exit;
  }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- sweetalert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- icono -->
    <script src="https://kit.fontawesome.com/e1d55cc160.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <!-- fuente de google Montserrat -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: 'Montserrat', sans-serif;
            margin: 0;
        }

        .login-container {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        .login-container h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #343a40;
        }

        .btn-login {
            background-color: #023047;
            border: none;
            color: white;
        }

        .btn-login:hover {
            background-color: #fb8500;
        }

        .forgot-password {
            text-align: center;
            display: block;
            margin-top: 10px;
            text-decoration: none;
            color: #023047;
        }
        .new_account {
            text-align: center;
            display: block;
            margin-top: 10px;
            color: #023047;
            text-decoration: none;
            font-size: 0.9em;
        }
        .new_account:hover, .forgot-password:hover {
            text-decoration: underline;
        }

        .forgot-password:hover {
            text-decoration: underline;
        }
        .logo-img{
            border-radius: 50%;
            width: 112px;
            height: 112px;
            margin: 0 auto;
            display: block;
            cursor: pointer;

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
        
    </script>
</head>
<body>
    <div class="login-container">
      <img src="img/logoBiBoLive.webp" onclick="window.location.href='index.php'" alt="logo" class="logo-img">	
        <h2>Iniciar Sesión</h2>
        <!-- formulario -->
        <form action="login.php" method="POST">
            <div class="mb-3">
                <label for="email" class="form-label">Correo electrónico</label>
                <input type="email" class="form-control" id="correo" name="correo" required>
            </div>

            <div class="mb-3 password-wrapper">
                <label for="password" class="form-label">Password</label>
                <input name="password" id="password" type="password" class="form-control" id="password" >
                <i id="eyepassword" class="fas fa-eye toggle-password" onclick="mostrarContraseña('password','eyepassword')"></i>
            </div>  

            <button type="submit" class="btn btn-login w-100">Ingresar</button>
            <br>
            <br>
            <a href="recuperar.php" class="forgot-password">¿Olvidaste tu contraseña?</a>
            
            <a href="signup.php" class="new_account">crear una cuenta en Bicentenario BoLive</a>
        </form>
    </div>
</body>
</html>

<?php

?>