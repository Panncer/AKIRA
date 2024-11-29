<?php

// Función para generar un reporte de inventario con filtros
function generarReporteInventarioFiltrado($filtro_nombre, $filtro_ubicacion) {
  global $conn;

  $sql = "SELECT * FROM activos WHERE 1=1"; // Empezar con una condición siempre verdadera

  if (!empty($filtro_nombre)) {
    $sql .= " AND nombre LIKE '%$filtro_nombre%'";
  }

  if (!empty($filtro_ubicacion)) {
    $sql .= " AND ubicacion = '$filtro_ubicacion'";
  }

  $result = $conn->query($sql);

  // ... (Generar el PDF con FPDF usando los datos de $result) ...
}

// Función para generar un reporte gráfico de la evolución del stock
function generarReporteGraficoStock() {
  // Implementa aquí la lógica para generar el reporte gráfico
  // Puedes usar una librería como "JpGraph" o "Chart.js"
}

?>