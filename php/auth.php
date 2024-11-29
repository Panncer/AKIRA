<?php

function login($correo, $contraseña) {
  global $conn; // Acceder a la variable de conexión global

  $sql = "SELECT * FROM usuarios WHERE correo = '$correo' AND contraseña = '$contraseña'";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $_SESSION["id_usuario"] = $row["id_usuario"];
    $_SESSION["nombre"] = $row["nombre"];
    $_SESSION["rol"] = $row["rol"];
    return true;
  } else {
    return false;
  }
}

function logout() {
  session_destroy();
  header("Location: ../index.php");
  exit();
}

?>