<?php
session_start();

if (!isset($_SESSION["id_usuario"])) {
  header("Location: ../../index.php");
  exit();
}

// Verificar si el usuario tiene permisos para eliminar personal (solo administrador)
if ($_SESSION["rol"] != 'administrador') {
  header("Location: listar.php"); 
  exit();
}

include_once '../../php/conexion.php';

if (isset($_GET["id"])) {
  $id_personal = $_GET["id"];

  $sql = "DELETE FROM personal WHERE id_personal = $id_personal";

  if ($conn->query($sql) === TRUE) {
    $mensaje = "Personal eliminado correctamente.";
  } else {
    $error = "Error al eliminar el personal: " . $conn->error;
  }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
  <title>AKIRA - Eliminar Personal</title>
  <link rel="stylesheet" href="../../css/style.css">
</head>
<body>

<?php include_once '../../includes/header.php'; ?>

<div class="container">
  <h1>Eliminar Personal</h1>

  <?php if (isset($mensaje)) { echo "<p class='mensaje'>$mensaje</p>"; } ?>
  <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>

  <?php if (isset($_GET["id"])) { ?>
    <p>¿Estás seguro de que quieres eliminar este miembro del personal?</p>
    <a href="listar.php">Cancelar</a>
  <?php } else { ?>
    <p>No se ha especificado ningún personal para eliminar.</p>
    <a href="listar.php">Volver a la lista de personal</a>
  <?php } ?>

</div>

<?php include_once '../../includes/footer.php'; ?>

</body>
</html>