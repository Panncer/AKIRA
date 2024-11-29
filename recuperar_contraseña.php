<?php
include_once 'php/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $correo = $_POST["correo"];

  // Verificar si el correo existe en la base de datos
  $sql = "SELECT * FROM usuarios WHERE correo = '$correo'";
  $result = $conn->query($sql);

  // ... (código anterior) ...

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $id_usuario = $row["id_usuario"];

    // Generar un código de recuperación aleatorio
    $codigo_recuperacion = bin2hex(random_bytes(16));

    // Calcular la fecha de expiración (por ejemplo, 1 hora)
    $fecha_expiracion = date("Y-m-d H:i:s", strtotime("+1 hour"));

    // Guardar el código de recuperación en la base de datos
    $sql = "INSERT INTO codigos_recuperacion (id_usuario, codigo, fecha_expiracion) 
            VALUES ('$id_usuario', '$codigo_recuperacion', '$fecha_expiracion')";

    if ($conn->query($sql) === TRUE) {
      // ... (enviar correo electrónico) ...
    } else {
      $error = "Error al generar el código de recuperación: " . $conn->error;
    }
  } else {
    // ... (el correo electrónico no está registrado) ...
  }



    // Enviar correo electrónico con el enlace de recuperación
    $enlace_recuperacion = "http://tu-dominio.com/restablecer_contraseña.php?codigo=" . $codigo_recuperacion;
    $mensaje = "Hola,\n\nPara restablecer tu contraseña, haz clic en el siguiente enlace:\n\n" . $enlace_recuperacion . "\n\nSi no solicitaste restablecer tu contraseña, ignora este correo.\n\nAtentamente,\nEl equipo de AKIRA";
    mail($correo, "Recuperación de contraseña de AKIRA", $mensaje);

    $mensaje = "Se ha enviado un correo electrónico con instrucciones para restablecer tu contraseña.";
  } else {
    $error = "El correo electrónico no está registrado.";
  }


$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
  <title>AKIRA - Recuperar Contraseña</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <div class="container">
    <h1>Recuperar Contraseña</h1>
    <?php if (isset($mensaje)) { echo "<p class='mensaje'>$mensaje</p>"; } ?>
    <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
      <input type="email" name="correo" placeholder="Correo electrónico" required>
      <button type="submit">Enviar correo de recuperación</button>
    </form>
  </div>
</body>
</html>