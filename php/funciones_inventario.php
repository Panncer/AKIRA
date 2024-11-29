<?php

// Función para calcular el valor total del inventario
function calcularValorInventario() {
  global $conn;
  $valor_total = 0;
  
  $sql = "SELECT * FROM activos";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      // Suponiendo que tienes un campo "precio_unitario" en la tabla "activos"
      $valor_total += $row["stock"] * $row["precio_unitario"]; 
    }
  }

  return $valor_total;
}

// Función para generar un código de barras en formato Code128 (requiere una librería externa)
function generarCodigoBarras($codigo) {
  // Implementa aquí la lógica para generar el código de barras
  // Puedes usar una librería como "barcode.php" o "php-barcode-generator"
}

?>