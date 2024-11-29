<?php
session_start();

if (!isset($_SESSION["id_usuario"])) {
  header("Location: ../../index.php");
  exit();
}

require('../../fpdf/fpdf.php'); // Reemplaza con la ruta correcta a tu archivo fpdf.php

include_once '../../php/conexion.php';

$sql = "SELECT m.*, a.nombre AS nombre_activo 
        FROM mantenimiento m
        INNER JOIN activos a ON m.id_activo = a.id_activo";
$result = $conn->query($sql);

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->Cell(40,10,'Reporte de Mantenimiento');
$pdf->Ln(20);

$pdf->SetFont('Arial','B',12);
$pdf->Cell(10,10,'ID',1);
$pdf->Cell(50,10,'Activo',1);
$pdf->Cell(40,10,'Fecha',1);
$pdf->Cell(70,10,'Descripción',1);
$pdf->Cell(20,10,'Estado',1);
$pdf->Ln();

$pdf->SetFont('Arial','',12);

if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    $pdf->Cell(10,10,$row["id_mantenimiento"],1);
    $pdf->Cell(50,10,$row["nombre_activo"],1);
    $pdf->Cell(40,10,$row["fecha_proximo"],1);
    $pdf->Cell(70,10,$row["descripcion"],1);
    $pdf->Cell(20,10,$row["estado"],1);
    $pdf->Ln();
  }
} else {
  $pdf->Cell(190,10,'No se encontraron tareas de mantenimiento.',1,0,'C');
}

$pdf->Output();

$conn->close();
?>