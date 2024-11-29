<?php
session_start();

if (!isset($_SESSION["id_usuario"])) {
  header("Location: ../../index.php");
  exit();
}

// Verificar si el usuario tiene permisos para editar activos
if ($_SESSION["rol"] != 'administrador' && $_SESSION["rol"] != 'operador') {
  header("Location: listar.php"); 
  exit();
}

include_once '../../php/conexion.php';

if (isset($_GET["id"])) {
  $id_activo = $_GET["id"];

  // Obtener los datos del activo
  $sql = "SELECT * FROM activos WHERE id_activo = $id_activo";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $nombre = $row["nombre"];
    $descripcion = $row["descripcion"];
    $stock = $row["stock"];
    $fecha_adquisicion = $row["fecha_adquisicion"];
    $ubicacion = $row["ubicacion"];
  } else {
    $error = "Activo no encontrado.";
  }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $nombre = $_POST["nombre"];
  $descripcion = $_POST["descripcion"];
  $stock = $_POST["stock"];
  $fecha_adquisicion = $_POST["fecha_adquisicion"];
  $ubicacion = $_POST["ubicacion"];

  $sql = "UPDATE activos SET 
          nombre='$nombre', 
          descripcion='$descripcion', 
          stock='$stock', 
          fecha_adquisicion='$fecha_adquisicion', 
          ubicacion='$ubicacion' 
          WHERE id_activo=$id_activo";

  if ($conn->query($sql) === TRUE) {
    $mensaje = "Activo actualizado correctamente.";
  } else {
    $error = "Error al actualizar el activo: " . $conn->error;
  }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
  <title>AKIRA - Editar Activo</title>
  <link rel="stylesheet" href="../../css/style.css">
</head>
<body>

<?php include_once '../../includes/header.php'; ?>

<div class="container">
  <h1>Editar Activo</h1>

  <?php if (isset($mensaje)) { echo "<p class='mensaje'>$mensaje</p>"; } ?>
  <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>

  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id=" . $id_activo); ?>">
    <label for="nombre">Nombre:</label>
    <input type="text" name="nombre" value="<?php echo $nombre; ?>" required><br><br>

    <label for="descripcion">Descripción:</label>
    <textarea name="descripcion"><?php echo $descripcion; ?></textarea><br><br>

    <label for="stock">Stock:</label>
    <input type="number" name="stock" value="<?php echo $stock; ?>" required><br><br>

    <label for="fecha_adquisicion">Fecha de Adquisición:</label>
    <input type="date" name="fecha_adquisicion" value="<?php echo $fecha_adquisicion; ?>"><br><br>

    <label for="ubicacion">Ubicación:</label>
    <input type="text" name="ubicacion" value="<?php echo $ubicacion; ?>"><br><br>

    <button type="submit">Guardar Cambios</button>
  </form>

</div>

<?php include_once '../../includes/footer.php'; ?>

</body>
</html>