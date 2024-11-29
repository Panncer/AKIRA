<?php
session_start();

if (!isset($_SESSION["id_usuario"])) {
  header("Location: ../../index.php");
  exit();
}

include_once '../../php/conexion.php';

$sql = "SELECT * FROM activos";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html>
<head>
  <title>AKIRA - Listar Activos</title>
  <link rel="stylesheet" href="../../css/style.css">
</head>
<body>

<?php include_once '../../includes/header.php'; ?>

<div class="container">
  <h1>Lista de Activos</h1>

  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Descripción</th>
        <th>Stock</th>
        <th>Fecha de Adquisición</th>
        <th>Ubicación</th>
        <?php if ($_SESSION["rol"] == 'administrador' || $_SESSION["rol"] == 'operador') { ?>
          <th>Acciones</th>
        <?php } ?>
      </tr>
    </thead>
    <tbody>
      <?php
      if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
          echo "<tr>";
          echo "<td>" . $row["id_activo"]. "</td>";
          echo "<td>" . $row["nombre"]. "</td>";
          echo "<td>" . $row["descripcion"]. "</td>";
          echo "<td";

          // Resaltar en rojo si el stock es menor a 10
          if ($row["stock"] < 10) {
            echo " class='rojo'";
          }

          echo ">" . $row["stock"]. "</td>";
          echo "<td>" . $row["fecha_adquisicion"]. "</td>";
          echo "<td>" . $row["ubicacion"]. "</td>";

          // Mostrar botones de editar y eliminar solo para administradores y operadores
          if ($_SESSION["rol"] == 'administrador' || $_SESSION["rol"] == 'operador') {
            echo "<td>";
            echo "<a href='editar.php?id=" . $row["id_activo"] . "'>Editar</a> ";
            echo "<a href='eliminar.php?id=" . $row["id_activo"] . "'>Eliminar</a>";
            echo "</td>";
          }

          echo "</tr>";
        }
      } else {
        echo "<tr><td colspan='7'>No se encontraron activos.</td></tr>";
      }
      $conn->close();
      ?>
    </tbody>
  </table>

</div>

<?php include_once '../../includes/footer.php'; ?>

</body>
</html>