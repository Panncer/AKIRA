<?php
session_start();

if (!isset($_SESSION["id_usuario"])) {
  header("Location: ../../index.php");
  exit();
}

include_once '../../php/conexion.php';

$sql = "SELECT m.*, a.nombre AS nombre_activo 
        FROM mantenimiento m
        INNER JOIN activos a ON m.id_activo = a.id_activo";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html>
<head>
  <title>AKIRA - Listar Mantenimientos</title>
  <link rel="stylesheet" href="../../css/style.css">
</head>
<body>

<?php include_once '../../includes/header.php'; ?>

<div class="container">
  <h1>Lista de Mantenimientos Programados</h1>

  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Activo</th>
        <th>Fecha Próximo Mantenimiento</th>
        <th>Descripción</th>
        <th>Estado</th>
        <?php if ($_SESSION["rol"] == 'administrador' || $_SESSION["rol"] == 'mantenimiento') { ?>
          <th>Acciones</th>
        <?php } ?>
      </tr>
    </thead>
    <tbody>
      <?php
      if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
          echo "<tr>";
          echo "<td>" . $row["id_mantenimiento"]. "</td>";
          echo "<td>" . $row["nombre_activo"]. "</td>";
          echo "<td>" . $row["fecha_proximo"]. "</td>";
          echo "<td>" . $row["descripcion"]. "</td>";
          echo "<td>" . $row["estado"]. "</td>";

          // Mostrar botones de editar y registrar solo para administradores y personal de mantenimiento
          if ($_SESSION["rol"] == 'administrador' || $_SESSION["rol"] == 'mantenimiento') {
            echo "<td>";
            // Mostrar botón de registrar solo si el estado es "pendiente"
            if ($row["estado"] == 'pendiente') {
              echo "<a href='registrar.php?id=" . $row["id_mantenimiento"] . "'>Registrar</a> ";
            }
            echo "<a href='editar.php?id=" . $row["id_mantenimiento"] . "'>Editar</a> ";
            echo "<a href='eliminar.php?id=" . $row["id_mantenimiento"] . "'>Eliminar</a>";
            echo "</td>";
          }

          echo "</tr>";
        }
      } else {
        echo "<tr><td colspan='6'>No se encontraron mantenimientos programados.</td></tr>";
      }
      $conn->close();
      ?>
    </tbody>
  </table>

</div>

<?php include_once '../../includes/footer.php'; ?>

</body>
</html>