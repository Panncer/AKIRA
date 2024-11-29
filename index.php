<?php
session_start();

include_once 'php/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $correo = $_POST["correo"];
  $contraseña = $_POST["contraseña"];

  $sql = "SELECT * FROM usuarios WHERE correo = '$correo' AND contraseña = '$contraseña'";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $_SESSION["id_usuario"] = $row["id_usuario"];
    $_SESSION["nombre"] = $row["nombre"];
    $_SESSION["rol"] = $row["rol"];

    header("Location: modulos/dashboard.php"); // Redirigir al dashboard después del login
  } else {
    $error = "Correo o contraseña incorrectos";
  }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
  <title>AKIRA - Login</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <div class="container">
    <h1>AKIRA</h1>
    <h2>Inicio de sesión</h2>
    <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
      <input type="email" name="correo" placeholder="Correo electrónico" required>
      <input type="password" name="contraseña" placeholder="Contraseña" required>
      <button type="submit">Iniciar sesión</button>
    </form>
    <a href="recuperar_contraseña.php">Olvidé mi contraseña</a> 
  </div>
</body>
</html>
