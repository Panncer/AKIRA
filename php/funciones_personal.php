<?php

// Función para calcular la nómina de un empleado
function calcularNomina($id_personal, $horas_trabajadas) {
  global $conn;

  // Obtener el salario por hora del empleado desde la base de datos
  $sql = "SELECT salario_hora FROM personal WHERE id_personal = $id_personal"; 
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $salario_hora = $row["salario_hora"];

    // Calcular la nómina
    $nomina = $horas_trabajadas * $salario_hora;

    return $nomina;
  } else {
    return 0; // O manejar el error de alguna otra forma
  }
}

// Función para gestionar las vacaciones de un empleado
function gestionarVacaciones($id_personal, $fecha_inicio, $fecha_fin) {
  // Implementa aquí la lógica para gestionar las vacaciones del empleado
  // Puedes guardar la información en una tabla "vacaciones"
}

?>