<?php
session_start();

if (!isset($_SESSION["id_usuario"])) {
  header("Location: ../../index.php");
  exit();
}

// Verificar si el usuario tiene permisos para registrar mantenimiento 
if ($_SESSION["rol"] != 'administrador' && $_SESSION["rol"] != 'mantenimiento') {
  header("Location: listar.php"); 
  exit();
}

include_once '../../php/conexion.php';

if (isset($_GET["id"])) {
  $id_mantenimiento = $_GET["id"];

  // Obtener los datos del mantenimiento
  $sql = "SELECT * FROM mantenimiento WHERE id_mantenimiento = $id_mantenimiento";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
  } else {
    $error = "Mantenimiento no encontrado.";
  }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $estado = 'realizado';

  $sql = "UPDATE mantenimiento SET 
          estado='$estado'
          WHERE id_mantenimiento=$id_mantenimiento";

  if ($conn->query($sql) === TRUE) {
    $mensaje = "Mantenimiento registrado como realizado.";
  } else {
    $error = "Error al registrar el mantenimiento: " . $conn->error;
  }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
  <title>AKIRA - Registrar Mantenimiento</title>
  <link rel="stylesheet" href="../../css/style.css">
</head>
<body>

<?php include_once '../../includes/header.php'; ?>

<div class="container">
  <h1>Registrar Mantenimiento</h1>

  <?php if (isset($mensaje)) { echo "<p class='mensaje'>$mensaje</p>"; } ?>
  <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>

  <?php if (isset($_GET["id"])) { ?>
    <p>¿Confirma que el mantenimiento con ID <?php echo $id_mantenimiento; ?> ha sido realizado?</p>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id=" . $id_mantenimiento); ?>">
      <button type="submit">Registrar como Realizado</button>
    </form>
    <a href="listar.php">Cancelar</a>
  <?php } else { ?>
    <p>No se ha especificado ningún mantenimiento para registrar.</p>
    <a href="listar.php">Volver a la lista de mantenimientos</a>
  <?php } ?>

</div>

<?php include_once '../../includes/footer.php'; ?>

</body>
</html>