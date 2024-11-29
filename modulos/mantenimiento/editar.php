<?php
session_start();

if (!isset($_SESSION["id_usuario"])) {
  header("Location: ../../index.php");
  exit();
}

// Verificar si el usuario tiene permisos para editar mantenimiento (solo administrador)
if ($_SESSION["rol"] != 'administrador') {
  header("Location: listar.php"); 
  exit();
}

include_once '../../php/conexion.php';

if (isset($_GET["id"])) {
  $id_mantenimiento = $_GET["id"];

  // Obtener los datos del mantenimiento
  $sql = "SELECT m.*, a.nombre AS nombre_activo 
          FROM mantenimiento m
          INNER JOIN activos a ON m.id_activo = a.id_activo
          WHERE id_mantenimiento = $id_mantenimiento";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $id_activo = $row["id_activo"];
    $fecha_proximo = $row["fecha_proximo"];
    $descripcion = $row["descripcion"];
    $estado = $row["estado"];
  } else {
    $error = "Mantenimiento no encontrado.";
  }

  // Obtener la lista de activos para el select
  $sql_activos = "SELECT id_activo, nombre FROM activos";
  $result_activos = $conn->query($sql_activos);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $id_activo = $_POST["id_activo"];
  $fecha_proximo = $_POST["fecha_proximo"];
  $descripcion = $_POST["descripcion"];
  $estado = $_POST["estado"];

  $sql = "UPDATE mantenimiento SET 
          id_activo='$id_activo',
          fecha_proximo='$fecha_proximo', 
          descripcion='$descripcion',
          estado='$estado'
          WHERE id_mantenimiento=$id_mantenimiento";

  if ($conn->query($sql) === TRUE) {
    $mensaje = "Mantenimiento actualizado correctamente.";
  } else {
    $error = "Error al actualizar el mantenimiento: " . $conn->error;
  }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
  <title>AKIRA - Editar Mantenimiento</title>
  <link rel="stylesheet" href="../../css/style.css">
</head>
<body>

<?php include_once '../../includes/header.php'; ?>

<div class="container">
  <h1>Editar Mantenimiento</h1>

  <?php if (isset($mensaje)) { echo "<p class='mensaje'>$mensaje</p>"; } ?>
  <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>

  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id=" . $id_mantenimiento); ?>">
    <label for="id_activo">Activo:</label>
    <select name="id_activo" required>
      <?php
      if ($result_activos->num_rows > 0) {
        while($row = $result_activos->fetch_assoc()) {
          $selected = ($row["id_activo"] == $id_activo) ? 'selected' : '';
          echo "<option value='" . $row["id_activo"] . "' $selected>" . $row["nombre"] . "</option>";
        }
      }
      ?>
    </select><br><br>

    <label for="fecha_proximo">Fecha Próximo Mantenimiento:</label>
    <input type="date" name="fecha_proximo" value="<?php echo $fecha_proximo; ?>" required><br><br>

    <label for="descripcion">Descripción:</label>
    <textarea name="descripcion"><?php echo $descripcion; ?></textarea><br><br>

    <label for="estado">Estado:</label>
    <select name="estado">
      <option value="pendiente" <?php if ($estado == 'pendiente') echo 'selected'; ?>>Pendiente</option>
      <option value="realizado" <?php if ($estado == 'realizado') echo 'selected'; ?>>Realizado</option>
    </select><br><br>

    <button type="submit">Guardar Cambios</button>
  </form>

</div>

<?php include_once '../../includes/footer.php'; ?>

</body>
</html>