<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup - BicentenarioBoLive</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <!-- recaptcha -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <!-- icono -->
    <script src="https://kit.fontawesome.com/e1d55cc160.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <!-- fuente de google Montserrat -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #f8f9fa;
        }
        .signup-container {
            max-width: 500px;
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
          height: 96px;
          width: 96px;
          border-radius: 50%;
          margin-right: 10px;
        }
        .form-control::placeholder {
          color: rgba(0, 0, 0, 0.5); /* Color más opaco para el placeholder */
        }

        .form-control {
          color: rgba(0, 0, 0, 0.8); /* Texto del input más visible */
        }

        select.form-control {
          color: rgba(0, 0, 0, 0.5); /* Hace que el texto del select se vea más opaco */
        }
        .g-recaptcha {
          display: flex;
          justify-content: center;
          width: 100%;
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
            let fullName = document.getElementById('fullname').value.trim();
            let lastName = document.getElementById('lastname').value.trim();
            let email = document.getElementById('exampleInputEmail').value.trim();
            let password = document.getElementById('password').value;
            let password2 = document.getElementById('password2').value;
            let recaptchaElem = document.getElementsByName('g-recaptcha-response')[0];
            let recaptcha = recaptchaElem ? recaptchaElem.value.trim() : '';
            let gender = document.getElementById('gender').value;
            let department = document.getElementById('department').value;
            
            // Verificar que todos los campos estén llenos
            if (fullName === "" || lastName === "" || email === "" || password === "" || password2 === "") {
              alert("Por favor, complete todos los campos.");
              e.preventDefault();
              return;
            }
            
            // Verificar formato de correo básico
            let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                alert("Por favor, ingrese un correo electrónico válido.");
                e.preventDefault();
                return;
            }
            
            // Verificar longitud mínima de contraseña (por ejemplo, 6 caracteres)
            if (password.length < 6) {
                alert("La contraseña debe tener al menos 6 caracteres.");
                e.preventDefault();
                return;
            }  
            let passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).{6,}$/;
            if (!passwordRegex.test(password)) {
              alert("La contraseña debe tener al menos 6 caracteres, incluyendo una letra mayúscula, una minúscula,  número y un carácter especial.");
              e.preventDefault();
              return;
            }
            
            // Verificar que las contraseñas coincidan
            if (password !== password2) {
              alert("Las contraseñas no coinciden.");
              e.preventDefault();
              return;
            }
            
            // Verificar que reCAPTCHA esté completado
            if (recaptcha === "") {
              alert("Por favor, complete el reCAPTCHA.");
              e.preventDefault();
              return;
            }
            if (!gender) {
              alert("Por favor, seleccione su género.");
              e.preventDefault();
              return;
            }
          
            if (!department) {
                alert("Por favor, seleccione su departamento.");
                e.preventDefault();
                return;
            }
          });
        });
    </script>
</head>
<body>

<div class="container mt-5">
    <div class="signup-container">
        <!-- Logo y Nombre -->
        <div class="text-center">
            <img class="logo-img" src="img/logoBiBoLive.webp" alt="BicentenarioBoLive" width="80">
            <h3 class="mt-2">Bicentenario BoLive</h3>
        </div>
        
        <h4 class="text-center mt-3">Signup</h4>

        <form action="register.php" method="POST" id="registerForm">
          <div class="row">
            <div class="col-md-6">
                <label for="firstName" class="form-label">Nombres</label>
                <input type="text" class="form-control" id="fullname" name="name" placeholder="Ingrese sus nombres">
            </div>

            <div class="col-md-6">
                <label for="lastName" class="form-label">Apellidos</label>
                <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Ingrese sus apellidos">
            </div>

            <div class="col-md-6">
              <br>
              <label for="gender" class="form-label">Género</label>
              <select class="form-control" id="gender" name="gender" required>
                  <option value="" disabled selected>Seleccione su género</option>
                  <option value="Masculino">Masculino</option>
                  <option value="Femenino">Femenino</option>
                  <option value="Otro">Otro</option>
              </select>
            </div>

            <div class="col-md-6">
              <br>
              <label for="country" class="form-label">País</label>
              <select class="form-control" id="country" name="country" required onchange="mostrarDepartamentos()">
                <option value="" disabled selected>Seleccione un país</option>
                <option value="Bolivia">Bolivia</option>
                <option value="Argentina">Argentina</option>
                <option value="Perú">Perú</option>
                <option value="México">México</option>
                <option value="Colombia">Colombia</option>
              </select>
              <br>
              <label for="deptos" class="form-label">ciudad</label>
              <select class="form-control" id="deptos" name="deptos">
                <option value="" disabled selected>Seleccione una ciudad</option>
                <option value="La Paz">La Paz</option>
                <option value="Cochabamba">Cochabamba</option>
                <option value="Santa Cruz">Santa Cruz</option>
                <option value="Oruro">Oruro</option>
                <option value="Potosí">Potosí</option>
                <option value="Chuquisaca">Chuquisaca</option>
                <option value="Tarija">Tarija</option>
                <option value="Beni">Beni</option>
                <option value="Pando">Pando</option>
              </select>
            </div>
          </div>
          <br>
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control" name="correo" id="exampleInputEmail" placeholder="Ingrese su email">
            </div>

            <div class="mb-3 password-wrapper">
                <label for="password" class="form-label">Password</label>
                <input name="pasw" id="password" type="password" class="form-control" id="password" >
                <i id="eyepassword" class="fas fa-eye toggle-password" onclick="mostrarContraseña('password','eyepassword')"></i>
            </div>

            <div class="mb-3 password-wrapper">
                <label for="confirmPassword" class="form-label">Repita Password</label>
                <input type="password" class="form-control" id="password2">
                <i id="eyepassword2" class="fas fa-eye toggle-password" onclick="mostrarContraseña('password2','eyepassword2')"></i>
            </div>

            <!-- reCAPTCHA -->
            <div class="form-group">
                <div class="g-recaptcha" data-sitekey="6LdKk-gqAAAAAD9mEchU4Ai9-sAQTzDzIzTcHwWO">
                </div>
                <br>
            </div>

            <button type="submit" class="btn btn-primary w-100">Submit</button>
        </form>
    </div>
</div>

</body>
</html>
