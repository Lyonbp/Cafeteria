<?php
	include 'plantilla.php';
	require 'conexion.php';
	
	$query = "SELECT * FROM empleado";
	$resultado = $mysqli->query($query);
	
	$pdf = new PDF();
	$pdf->AliasNbPages();
	$pdf->AddPage();

	$pdf->SetFont('Arial', 'I', 15);
	$pdf->Cell(0, 5, 'Reporte de Empleados', 0, 0, 'C');
	$pdf->Ln(10);
	
	$pdf->SetFillColor(140,161,185);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(30,20,'Nombre',1,0,'C',1);
	$pdf->Cell(60,20,'Apellido',1,0,'C',1);
	$pdf->Cell(70,20,'Gmail',1,0,'C',1);
	
	$pdf->Cell(20, 20, 'Foto', 1, 1, 'C', 1);



	$pdf->SetFont('Arial', '', 10);

	while($row = $resultado->fetch_assoc())
	{
		$pdf->Cell(30, 20, $row['nombre'], 1, 0, 'C');
		$pdf->Cell(60, 20, $row['apellido'], 1, 0, 'C');
		$pdf->Cell(70, 20, $row['gmail'], 1, 0, 'C');
		// AQUIIIIIIIIIIIIIIIIIIIIIII: 
		$pdf->Cell(20, 20, $pdf->Image("img/".$row['imagen'], $pdf->GetX()+0, $pdf->GetY()+0, 20), 1, 1, 'C');
	}


	$pdf->Output();
?>