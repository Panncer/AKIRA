<?php
session_start();

if (!isset($_SESSION["id_usuario"])) {
  header("Location: ../../index.php");
  exit();
}

// Verificar si el usuario tiene permisos para eliminar mantenimiento (solo administrador)
if ($_SESSION["rol"] != 'administrador') {
  header("Location: listar.php"); 
  exit();
}

include_once '../../php/conexion.php';

if (isset($_GET["id"])) {
  $id_mantenimiento = $_GET["id"];

  $sql = "DELETE FROM mantenimiento WHERE id_mantenimiento = $id_mantenimiento";

  if ($conn->query($sql) === TRUE) {
    $mensaje = "Mantenimiento eliminado correctamente.";
  } else {
    $error = "Error al eliminar el mantenimiento: " . $conn->error;
  }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
  <title>AKIRA - Eliminar Mantenimiento</title>
  <link rel="stylesheet" href="../../css/style.css">
</head>
<body>

<?php include_once '../../includes/header.php'; ?>

<div class="container">
  <h1>Eliminar Mantenimiento</h1>

  <?php if (isset($mensaje)) { echo "<p class='mensaje'>$mensaje</p>"; } ?>
  <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>

  <?php if (isset($_GET["id"])) { ?>
    <p>¿Estás seguro de que quieres eliminar este mantenimiento programado?</p>
    <a href="listar.php">Cancelar</a>
  <?php } else { ?>
    <p>No se ha especificado ningún mantenimiento para eliminar.</p>
    <a href="listar.php">Volver a la lista de mantenimientos</a>
  <?php } ?>

</div>

<?php include_once '../../includes/footer.php'; ?>

</body>
</html>