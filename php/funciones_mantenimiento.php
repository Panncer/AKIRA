<?php

// Función para enviar notificaciones automáticas sobre mantenimientos próximos
function enviarNotificacionesMantenimiento() {
  global $conn;

  // Obtener los mantenimientos programados para los próximos días (por ejemplo, 7 días)
  $sql = "SELECT m.*, a.nombre AS nombre_activo
          FROM mantenimiento m
          INNER JOIN activos a ON m.id_activo = a.id_activo
          WHERE m.fecha_proximo BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 7 DAY)
          AND m.estado = 'pendiente'"; 
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      $nombre_activo = $row["nombre_activo"];
      $fecha_proximo = $row["fecha_proximo"];
      // Obtener el correo del usuario responsable del activo (requiere cambios en la tabla 'activos')
      $id_activo = $row["id_activo"];
      $sql_usuario = "SELECT u.correo FROM usuarios u 
                      INNER JOIN activos a ON u.id_usuario = a.id_usuario_responsable 
                      WHERE a.id_activo = $id_activo";
      $result_usuario = $conn->query($sql_usuario);
      if ($result_usuario->num_rows > 0) {
        $row_usuario = $result_usuario->fetch_assoc();
        $correo_usuario = $row_usuario["correo"];

        // Enviar correo electrónico al usuario responsable
        $mensaje = "Hola,\n\nTe recordamos que el activo '$nombre_activo' tiene un mantenimiento programado para el $fecha_proximo.\n\nPor favor, revisa el sistema AKIRA para más detalles.\n\nAtentamente,\nEl equipo de AKIRA";
        mail($correo_usuario, "Recordatorio de Mantenimiento de AKIRA", $mensaje);
      } else {
        // Manejar el caso en que no se encuentre un usuario responsable
        error_log("No se encontró un usuario responsable para el activo con ID: " . $id_activo);
      }
    }
  }
}

?>