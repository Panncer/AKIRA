<?php
session_start();

if (!isset($_SESSION["id_usuario"])) {
  header("Location: ../../index.php");
  exit();
}

// Verificar si el usuario tiene permisos para agregar usuarios (solo administrador)
if ($_SESSION["rol"] != 'administrador') {
  header("Location: listar.php"); 
  exit();
}

include_once '../../php/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $nombre = $_POST["nombre"];
  $correo = $_POST["correo"];
  $contraseña = $_POST["contraseña"]; // ¡Recuerda encriptar la contraseña antes de guardarla!
  $rol = $_POST["rol"];

  // Encriptar la contraseña
  $contraseña_encriptada = password_hash($contraseña, PASSWORD_DEFAULT);

  $sql = "INSERT INTO usuarios (nombre, correo, contraseña, rol) 
          VALUES ('$nombre', '$correo', '$contraseña_encriptada', '$rol')";

  if ($conn->query($sql) === TRUE) {
    $mensaje = "Usuario agregado correctamente.";
  } else {
    $error = "Error al agregar el usuario: " . $conn->error;
  }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
  <title>AKIRA - Agregar Usuario</title>
  <link rel="stylesheet" href="../../css/style.css">
</head>
<body>

<?php include_once '../../includes/header.php'; ?>

<div class="container">
  <h1>Agregar Usuario</h1>

  <?php if (isset($mensaje)) { echo "<p class='mensaje'>$mensaje</p>"; } ?>
  <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>

  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label for="nombre">Nombre:</label>
    <input type="text" name="nombre" required><br><br>

    <label for="correo">Correo:</label>
    <input type="email" name="correo" required><br><br>

    <label for="contraseña">Contraseña:</label>
    <input type="password" name="contraseña" required><br><br>

    <label for="rol">Rol:</label>
    <select name="rol">
      <option value="administrador">Administrador</option>
      <option value="operador">Operador</option>
      <option value="mantenimiento">Mantenimiento</option>
    </select><br><br>

    <button type="submit">Agregar</button>
  </form>

</div>

<?php include_once '../../includes/footer.php'; ?>

</body>
</html>