<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BicentenarioBoLive Navbar</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- fuente de google Montserrat -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <style>
        *{
          font-family: 'Montserrat', sans-serif;
          font-size: 14px;
        }
        /* Ajustes personalizados */
        .logo-img {
            height: 40px;
            width: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }
        .navbar-brand {
            display: flex;
            align-items: center;
            font-size: 1.5em;
            font-weight: bold;
            color: #8ecae6 !important;
        }
        .navbar-nav .nav-link {
            color: #219ebc !important;
        }
        .navbar-nav .nav-link:hover {
            color: #ffb703 !important;
        }
        .btn-custom {
            background-color: #fb8500;
            color: white;
            border-radius: 5px;
        }
        .btn-custom:hover {
            background-color: #ffb703;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg" style="background-color: #023047;">
        <div class="container">
            <!-- Logo + Nombre -->
            <a class="navbar-brand" href="#">
                <img src="img/logoBiBoLive.webp" alt="logo" class="logo-img">
                BicentenarioBoLive
            </a>

            <!-- Botón de menú hamburguesa en móvil -->
            <!-- Botón con icono de Bootstrap -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <i class="bi bi-list" style="font-size: 35px; color: white;"></i>
            </button>

<!-- Agregar esto en el <head> para cargar Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">


            <!-- Menú -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-3 me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Eventos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Noticias</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Acerca</a>
                    </li>
                </ul>

                <!-- Botones Login/Signup -->
                <div class="d-flex">
                    <button class="btn btn-custom me-2" onclick="window.location.href='login.php'">Login</button>
                    <button class="btn btn-custom" onclick="window.location.href='signup.php';">Sign Up</button>
                </div>
            </div>
        </div>
    </nav>
</body>
</html>
