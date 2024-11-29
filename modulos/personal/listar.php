<?php
session_start();

if (!isset($_SESSION["id_usuario"])) {
  header("Location: ../../index.php");
  exit();
}

include_once '../../php/conexion.php';

$sql = "SELECT * FROM personal";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html>
<head>
  <title>AKIRA - Listar Personal</title>
  <link rel="stylesheet" href="../../css/style.css">
</head>
<body>

<?php include_once '../../includes/header.php'; ?>

<div class="container">
  <h1>Lista de Personal</h1>

  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Especialidad</th>
        <th>Disponibilidad</th>
        <?php if ($_SESSION["rol"] == 'administrador') { ?>
          <th>Acciones</th>
        <?php } ?>
      </tr>
    </thead>
    <tbody>
      <?php
      if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
          echo "<tr>";
          echo "<td>" . $row["id_personal"]. "</td>";
          echo "<td>" . $row["nombre"]. "</td>";
          echo "<td>" . $row["especialidad"]. "</td>";
          echo "<td>" . $row["disponibilidad"]. "</td>";

          // Mostrar botones de editar y eliminar solo para administradores
          if ($_SESSION["rol"] == 'administrador') {
            echo "<td>";
            echo "<a href='editar.php?id=" . $row["id_personal"] . "'>Editar</a> ";
            echo "<a href='eliminar.php?id=" . $row["id_personal"] . "'>Eliminar</a>";
            echo "</td>";
          }

          echo "</tr>";
        }
      } else {
        echo "<tr><td colspan='5'>No se encontró personal.</td></tr>";
      }
      $conn->close();
      ?>
    </tbody>
  </table>

</div>

<?php include_once '../../includes/footer.php'; ?>

</body>
</html>