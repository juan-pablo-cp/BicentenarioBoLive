<?php 
  $conexion = new mysqli('localhost','root','','bicentenario_bo_live');
  if($conexion-> connect_error) die('No se pudo conectar al servidor');
?>