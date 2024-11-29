<?php
session_start();

if (!isset($_SESSION["id_usuario"])) {
  header("Location: ../../index.php");
  exit();
}

// Verificar si el usuario tiene permisos para agregar activos
if ($_SESSION["rol"] != 'administrador' && $_SESSION["rol"] != 'operador') {
  header("Location: listar.php"); 
  exit();
}

include_once '../../php/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $nombre = $_POST["nombre"];
  $descripcion = $_POST["descripcion"];
  $stock = $_POST["stock"];
  $fecha_adquisicion = $_POST["fecha_adquisicion"];
  $ubicacion = $_POST["ubicacion"];

  $sql = "INSERT INTO activos (nombre, descripcion, stock, fecha_adquisicion, ubicacion) 
          VALUES ('$nombre', '$descripcion', '$stock', '$fecha_adquisicion', '$ubicacion')";

  if ($conn->query($sql) === TRUE) {
    $mensaje = "Activo agregado correctamente.";
  } else {
    $error = "Error al agregar el activo: " . $conn->error;
  }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
  <title>AKIRA - Agregar Activo</title>
  <link rel="stylesheet" href="../../css/style.css">
</head>
<body>

<?php include_once '../../includes/header.php'; ?>

<div class="container">
  <h1>Agregar Activo</h1>

  <?php if (isset($mensaje)) { echo "<p class='mensaje'>$mensaje</p>"; } ?>
  <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>

  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label for="nombre">Nombre:</label>
    <input type="text" name="nombre" required><br><br>

    <label for="descripcion">Descripción:</label> 1 
    <textarea name="descripcion"></textarea><br><br>

    <label for="stock">Stock:</label>
    <input type="number" name="stock" required><br><br>

    <label for="fecha_adquisicion">Fecha de Adquisición:</label>
    <input type="date" name="fecha_adquisicion"><br><br>

    <label for="ubicacion">Ubicación:</label>
    <input type="text" name="ubicacion"><br><br>

    <button type="submit">Agregar</button>
  </form>

</div>

<?php include_once '../../includes/footer.php'; ?>

</body>
</html>