<?php
session_start();

if (!isset($_SESSION["id_usuario"])) {
  header("Location: ../../index.php");
  exit();
}

// Verificar si el usuario tiene permisos para agregar personal (solo administrador)
if ($_SESSION["rol"] != 'administrador') {
  header("Location: listar.php"); 
  exit();
}

include_once '../../php/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $nombre = $_POST["nombre"];
  $especialidad = $_POST["especialidad"];
  $disponibilidad = $_POST["disponibilidad"];

  $sql = "INSERT INTO personal (nombre, especialidad, disponibilidad) 
          VALUES ('$nombre', '$especialidad', '$disponibilidad')";

  if ($conn->query($sql) === TRUE) {
    $mensaje = "Personal agregado correctamente.";
  } else {
    $error = "Error al agregar el personal: " . $conn->error;
  }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
  <title>AKIRA - Agregar Personal</title>
  <link rel="stylesheet" href="../../css/style.css">
</head>
<body>

<?php include_once '../../includes/header.php'; ?>

<div class="container">
  <h1>Agregar Personal</h1>

  <?php if (isset($mensaje)) { echo "<p class='mensaje'>$mensaje</p>"; } ?>
  <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>

  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label for="nombre">Nombre:</label>
    <input type="text" name="nombre" required><br><br>

    <label for="especialidad">Especialidad:</label>
    <input type="text" name="especialidad"><br><br>

    <label for="disponibilidad">Disponibilidad:</label>
    <select name="disponibilidad">
      <option value="disponible">Disponible</option>
      <option value="ocupado">Ocupado</option>
    </select><br><br>

    <button type="submit">Agregar</button>
  </form>

</div>

<?php include_once '../../includes/footer.php'; ?>

</body>
</html>