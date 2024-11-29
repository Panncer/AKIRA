<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>AKIRA - Sistema de Gestión de Inventarios</title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<header>
  <div class="container">
    <div class="logo">AKIRA</div> 
    <nav>
      <ul>
        <?php if (isset($_SESSION["id_usuario"])) { ?>
          <li><a href="../php/logout.php">Cerrar sesión</a></li>
        <?php } ?>
      </ul>
    </nav>
  </div>
</header>