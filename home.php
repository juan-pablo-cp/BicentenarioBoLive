<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
// Cerrar sesión al presionar el botón
if (isset($_POST['logout'])) {
  session_unset();
  session_destroy();
  header("Location: login.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Home - Bienvenido</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Bienvenido, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</h1>
        <p>Esta es tu página principal, donde podrás ver tu información y acceder a las funcionalidades exclusivas para usuarios.</p>
        <form method="POST">
          <button type="submit" name="logout" class="btn btn-danger">Cerrar Sesión</button>
        </form>
    </div>
</body>
</html>
