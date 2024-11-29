<?php
include_once 'php/conexion.php';

if (isset($_GET["codigo"])) {
  $codigo_recuperacion = $_GET["codigo"];

  // Verificar si el código de recuperación es válido y no ha expirado
  $sql = "SELECT * FROM codigos_recuperacion 
          WHERE codigo = '$codigo_recuperacion' 
          AND fecha_expiracion > NOW()";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    $codigo_valido = true;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $contraseña = $_POST["contraseña"];

      // Actualizar la contraseña en la base de datos (asegúrate de encriptarla)
      $contraseña_encriptada = password_hash($contraseña, PASSWORD_DEFAULT); 
      $sql = "UPDATE usuarios 
              SET contraseña = '$contraseña_encriptada'
              WHERE id_usuario = (SELECT id_usuario FROM codigos_recuperacion WHERE codigo = '$codigo_recuperacion')";

      if ($conn->query($sql) === TRUE) {
        // Eliminar el código de recuperación de la base de datos
        $sql = "DELETE FROM codigos_recuperacion WHERE codigo = '$codigo_recuperacion'";
        $conn->query($sql);

        $mensaje = "Contraseña restablecida correctamente.";
      } else {
        $error = "Error al restablecer la contraseña: " . $conn->error;
      }
    }
  } else {
    $error = "Código de recuperación inválido o expirado.";
  }
} else {
  $error = "Falta el código de recuperación.";
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
  <title>AKIRA - Restablecer Contraseña</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <div class="container">
    <h1>Restablecer Contraseña</h1>
    <?php if (isset($mensaje)) { echo "<p class='mensaje'>$mensaje</p>"; } ?>
    <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>
    <?php if (isset($codigo_valido) && $codigo_valido) { ?>
      <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?codigo=" . $codigo_recuperacion); ?>">
        <input type="password" name="contraseña" placeholder="Nueva contraseña" required>
        <button type="submit">Restablecer contraseña</button>
      </form>
    <?php } ?>
  </div>
</body>
</html>