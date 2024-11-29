<?php
session_start();

if (!isset($_SESSION["id_usuario"])) {
  header("Location: ../../index.php");
  exit();
}

// Verificar si el usuario tiene permisos para eliminar usuarios (solo administrador)
if ($_SESSION["rol"] != 'administrador') {
  header("Location: listar.php"); 
  exit();
}

include_once '../../php/conexion.php';

if (isset($_GET["id"])) {
  $id_usuario = $_GET["id"];

  // Verificar que el usuario a eliminar no sea el mismo que está logueado
  if ($id_usuario == $_SESSION["id_usuario"]) {
    $error = "No puedes eliminar tu propia cuenta.";
  } else {
    $sql = "DELETE FROM usuarios WHERE id_usuario = $id_usuario";

    if ($conn->query($sql) === TRUE) {
      $mensaje = "Usuario eliminado correctamente.";
    } else {
      $error = "Error al eliminar el usuario: " . $conn->error;
    }
  }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
  <title>AKIRA - Eliminar Usuario</title>
  <link rel="stylesheet" href="../../css/style.css">
</head>
<body>

<?php include_once '../../includes/header.php'; ?>

<div class="container">
  <h1>Eliminar Usuario</h1>

  <?php if (isset($mensaje)) { echo "<p class='mensaje'>$mensaje</p>"; } ?>
  <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>

  <?php if (isset($_GET["id"])) { ?>
    <p>¿Estás seguro de que quieres eliminar este usuario?</p>
    <a href="listar.php">Cancelar</a>
  <?php } else { ?>
    <p>No se ha especificado ningún usuario para eliminar.</p>
    <a href="listar.php">Volver a la lista de usuarios</a>
  <?php } ?>

</div>

<?php include_once '../../includes/footer.php'; ?>

</body>
</html>