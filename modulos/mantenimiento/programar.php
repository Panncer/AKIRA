<?php
session_start();

if (!isset($_SESSION["id_usuario"])) {
  header("Location: ../../index.php");
  exit();
}

// Verificar si el usuario tiene permisos para programar mantenimiento (solo administrador)
if ($_SESSION["rol"] != 'administrador') {
  header("Location: listar.php"); 
  exit();
}

include_once '../../php/conexion.php';

// Obtener la lista de activos para el select
$sql_activos = "SELECT id_activo, nombre FROM activos";
$result_activos = $conn->query($sql_activos);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $id_activo = $_POST["id_activo"];
  $fecha_proximo = $_POST["fecha_proximo"];
  $descripcion = $_POST["descripcion"];

  $sql = "INSERT INTO mantenimiento (id_activo, fecha_proximo, descripcion, estado) 
          VALUES ('$id_activo', '$fecha_proximo', '$descripcion', 'pendiente')";

  if ($conn->query($sql) === TRUE) {
    $mensaje = "Mantenimiento programado correctamente.";
  } else {
    $error = "Error al programar el mantenimiento: " . $conn->error;
  }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
  <title>AKIRA - Programar Mantenimiento</title>
  <link rel="stylesheet" href="../../css/style.css">
</head>
<body>

<?php include_once '../../includes/header.php'; ?>

<div class="container">
  <h1>Programar Mantenimiento</h1>

  <?php if (isset($mensaje)) { echo "<p class='mensaje'>$mensaje</p>"; } ?>
  <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>

  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label for="id_activo">Activo:</label>
    <select name="id_activo" required>
      <option value="">Seleccionar activo</option>
      <?php
      if ($result_activos->num_rows > 0) {
        while($row = $result_activos->fetch_assoc()) {
          echo "<option value='" . $row["id_activo"] . "'>" . $row["nombre"] . "</option>";
        }
      }
      ?>
    </select><br><br>

    <label for="fecha_proximo">Fecha Próximo Mantenimiento:</label>
    <input type="date" name="fecha_proximo" required><br><br>

    <label for="descripcion">Descripción:</label>
    <textarea name="descripcion"></textarea><br><br>

    <button type="submit">Programar</button>
  </form>

</div>

<?php include_once '../../includes/footer.php'; ?>

</body>
</html>