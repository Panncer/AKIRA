<?php
session_start();

if (!isset($_SESSION["id_usuario"])) {
  header("Location: ../index.php");
  exit();
}

include_once '../php/conexion.php';

// Obtener el rol del usuario
$rol = $_SESSION["rol"];

?>

<!DOCTYPE html>
<html>
<head>
  <title>AKIRA - Dashboard</title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<?php include_once '../includes/header.php'; ?>

<div class="container">
  <h1>Bienvenido, <?php echo $_SESSION["nombre"]; ?>!</h1>

  <div class="content"> 
    <?php 
    // Mostrar opciones del menú según el rol del usuario
    if ($rol == 'administrador') {
      include_once 'menu_admin.php'; 
    } elseif ($rol == 'operador') {
      include_once 'menu_operador.php'; 
    } elseif ($rol == 'mantenimiento') {
      include_once 'menu_mantenimiento.php'; 
    }
    ?>

    <div id="contenido">
      </div>
  </div> 
</div>

<?php include_once '../includes/footer.php'; ?>

<script src="../js/script.js"></script>
</body>
</html>