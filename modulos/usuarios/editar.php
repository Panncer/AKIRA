<?php
session_start();

if (!isset($_SESSION["id_usuario"])) {
  header("Location: ../../index.php");
  exit();
}

// Verificar si el usuario tiene permisos para editar usuarios (solo administrador)
if ($_SESSION["rol"] != 'administrador') {
  header("Location: listar.php"); 
  exit();
}

include_once '../../php/conexion.php';

if (isset($_GET["id"])) {
  $id_usuario = $_GET["id"];

  // Obtener los datos del usuario
  $sql = "SELECT * FROM usuarios WHERE id_usuario = $id_usuario";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $nombre = $row["nombre"];
    $correo = $row["correo"];
    $rol = $row["rol"];
  } else {
    $error = "Usuario no encontrado.";
  }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $nombre = $_POST["nombre"];
  $correo = $_POST["correo"];
  $rol = $_POST["rol"];

  $sql = "UPDATE usuarios SET 
          nombre='$nombre', 
          correo='$correo', 
          rol='$rol'
          WHERE id_usuario=$id_usuario";

  if ($conn->query($sql) === TRUE) {
    $mensaje = "Usuario actualizado correctamente.";
  } else {
    $error = "Error al actualizar el usuario: " . $conn->error;
  }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
  <title>AKIRA - Editar Usuario</title>
  <link rel="stylesheet" href="../../css/style.css">
</head>
<body>

<?php include_once '../../includes/header.php'; ?>

<div class="container">
  <h1>Editar Usuario</h1>

  <?php if (isset($mensaje)) { echo "<p class='mensaje'>$mensaje</p>"; } ?>
  <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>

  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id=" . $id_usuario); ?>">
    <label for="nombre">Nombre:</label>
    <input type="text" name="nombre" value="<?php echo $nombre; ?>" required><br><br>

    <label for="correo">Correo:</label>
    <input type="email" name="correo" value="<?php echo $correo; ?>" required><br><br>

    <label for="rol">Rol:</label>
    <select name="rol">
      <option value="administrador" <?php if ($rol == 'administrador') echo 'selected'; ?>>Administrador</option>
      <option value="operador" <?php if ($rol == 'operador') echo 'selected'; ?>>Operador</option>
      <option value="mantenimiento" <?php if ($rol == 'mantenimiento') echo 'selected'; ?>>Mantenimiento</option>
    </select><br><br>

    <button type="submit">Guardar Cambios</button>
  </form>

</div>

<?php include_once '../../includes/footer.php'; ?>

</body>
</html>