<?php
    include('conection.php');

    if(isset( $_POST['correo']) && isset($_POST['pasw'])){
        $nombre=$_POST['name'];
        $apellido=$_POST['lastname'];
        $email=$_POST['correo'];
        $pasw=$_POST['pasw'];

        // Primero, se consulta si el correo ya existe en la base de datos
        $consulta = "SELECT id FROM persona WHERE email = '$email'";
        $resultado = $conexion->query($consulta) or die($conexion->error);
        
        if($resultado->num_rows > 0){
            echo "<script>
                    alert('El correo ya está registrado.');
                    window.location.href = 'signup.php';
                </script>";
            
        }
        else include ('mail.php');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>register</title>
</head>
<body>
    <h2>register</h2>
</body>
</html>