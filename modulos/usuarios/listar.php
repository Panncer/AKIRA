<?php
session_start();

if (!isset($_SESSION["id_usuario"])) {
  header("Location: ../../index.php");
  exit();
}

// Verificar si el usuario tiene permisos para gestionar usuarios (solo administrador)
if ($_SESSION["rol"] != 'administrador') {
  header("Location: ../dashboard.php"); 
  exit();
}

include_once '../../php/conexion.php';

$sql = "SELECT * FROM usuarios";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html>
<head>
  <title>AKIRA - Listar Usuarios</title>
  <link rel="stylesheet" href="../../css/style.css">
</head>
<body>

<?php include_once '../../includes/header.php'; ?>

<div class="container">
  <h1>Lista de Usuarios</h1>

  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Correo</th>
        <th>Rol</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <?php
      if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
          echo "<tr>";
          echo "<td>" . $row["id_usuario"]. "</td>";
          echo "<td>" . $row["nombre"]. "</td>";
          echo "<td>" . $row["correo"]. "</td>";
          echo "<td>" . $row["rol"]. "</td>";
          echo "<td>";
          echo "<a href='editar.php?id=" . $row["id_usuario"] . "'>Editar</a> ";
          echo "<a href='eliminar.php?id=" . $row["id_usuario"] . "'>Eliminar</a>";
          echo "</td>";
          echo "</tr>";
        }
      } else {
        echo "<tr><td colspan='5'>No se encontraron usuarios.</td></tr>";
      }
      $conn->close();
      ?>
    </tbody>
  </table>

</div>

<?php include_once '../../includes/footer.php'; ?>

</body>
</html>