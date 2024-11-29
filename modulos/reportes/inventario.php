<?php
session_start();

if (!isset($_SESSION["id_usuario"])) {
  header("Location: ../../index.php");
  exit();
}

require('../../fpdf/fpdf.php'); // Reemplaza con la ruta correcta a tu archivo fpdf.php

include_once '../../php/conexion.php';

$sql = "SELECT * FROM activos";
$result = $conn->query($sql);

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->Cell(40,10,'Reporte de Inventario');
$pdf->Ln(20);

$pdf->SetFont('Arial','B',12);
$pdf->Cell(10,10,'ID',1);
$pdf->Cell(60,10,'Nombre',1);
$pdf->Cell(80,10,'Descripción',1);
$pdf->Cell(20,10,'Stock',1);
$pdf->Cell(20,10,'Ubicación',1);
$pdf->Ln();

$pdf->SetFont('Arial','',12);

if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    $pdf->Cell(10,10,$row["id_activo"],1);
    $pdf->Cell(60,10,$row["nombre"],1);
    $pdf->Cell(80,10,$row["descripcion"],1);
    $pdf->Cell(20,10,$row["stock"],1);
    $pdf->Cell(20,10,$row["ubicacion"],1);
    $pdf->Ln();
  }
} else {
  $pdf->Cell(190,10,'No se encontraron activos.',1,0,'C');
}

$pdf->Output();

$conn->close();
?>