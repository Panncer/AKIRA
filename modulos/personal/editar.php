<?php
session_start();

if (!isset($_SESSION["id_usuario"])) {
  header("Location: ../../index.php");
  exit();
}

// Verificar si el usuario tiene permisos para editar personal (solo administrador)
if ($_SESSION["rol"] != 'administrador') {
  header("Location: listar.php"); 
  exit();
}

include_once '../../php/conexion.php';

if (isset($_GET["id"])) {
  $id_personal = $_GET["id"];

  // Obtener los datos del personal
  $sql = "SELECT * FROM personal WHERE id_personal = $id_personal";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $nombre = $row["nombre"];
    $especialidad = $row["especialidad"];
    $disponibilidad = $row["disponibilidad"];
  } else {
    $error = "Personal no encontrado.";
  }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $nombre = $_POST["nombre"];
  $especialidad = $_POST["especialidad"];
  $disponibilidad = $_POST["disponibilidad"];

  $sql = "UPDATE personal SET 
          nombre='$nombre', 
          especialidad='$especialidad', 
          disponibilidad='$disponibilidad'
          WHERE id_personal=$id_personal";

  if ($conn->query($sql) === TRUE) {
    $mensaje = "Personal actualizado correctamente.";
  } else {
    $error = "Error al actualizar el personal: " . $conn->error;
  }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
  <title>AKIRA - Editar Personal</title>
  <link rel="stylesheet" href="../../css/style.css">
</head>
<body>

<?php include_once '../../includes/header.php'; ?>

<div class="container">
  <h1>Editar Personal</h1>

  <?php if (isset($mensaje)) { echo "<p class='mensaje'>$mensaje</p>"; } ?>
  <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>

  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id=" . $id_personal); ?>">
    <label for="nombre">Nombre:</label>
    <input type="text" name="nombre" value="<?php echo $nombre; ?>" required><br><br>

    <label for="especialidad">Especialidad:</label>
    <input type="text" name="especialidad" value="<?php echo $especialidad; ?>"><br><br>

    <label for="disponibilidad">Disponibilidad:</label>
    <select name="disponibilidad">
      <option value="disponible" <?php if ($disponibilidad == 'disponible') echo 'selected'; ?>>Disponible</option>
      <option value="ocupado" <?php if ($disponibilidad == 'ocupado') echo 'selected'; ?>>Ocupado</option>
    </select><br><br>

    <button type="submit">Guardar Cambios</button>
  </form>

</div>

<?php include_once '../../includes/footer.php'; ?>

</body>
</html>