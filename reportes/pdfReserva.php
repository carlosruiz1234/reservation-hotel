<?php
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetMargins(20, 20, 20);

// header
$pdf->SetFillColor(25, 0, 71);
$pdf->SetTextColor(255, 255, 255);
$pdf->SetFont('Arial', 'B', 18);
$pdf->Cell(0, 15, 'Hotel Paradise', 0, 1, 'C', true);

$pdf->SetFont('Arial', '', 11);
$pdf->Cell(0, 8, 'Comprobante de Reservacion', 0, 1, 'C', true);
$pdf->Ln(5);

// numero reserva
$pdf->SetFillColor(111, 66, 193);
$pdf->SetTextColor(255, 255, 255);
$pdf->SetFont('Arial', 'B', 13);
$pdf->Cell(0, 10, 'Reservacion #' . $datos['id'], 0, 1, 'C', true);
$pdf->Ln(8);

// datos cliente
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFillColor(240, 235, 255);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 9, 'Datos del Cliente', 0, 1, 'L', true);
$pdf->Ln(2);

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(50, 7, 'Nombre:', 0, 0);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(0, 7, $datos['usuario_nombre'] . ' ' . $datos['usuario_apellido'], 0, 1);

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(50, 7, 'Correo:', 0, 0);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(0, 7, $datos['usuario_email'], 0, 1);

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(50, 7, 'Telefono:', 0, 0);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(0, 7, $datos['usuario_telefono'], 0, 1);
$pdf->Ln(6);

// datos reserva
$pdf->SetFillColor(240, 235, 255);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 9, 'Datos de la Reservacion', 0, 1, 'L', true);
$pdf->Ln(2);

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(50, 7, 'Habitacion:', 0, 0);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(0, 7, $datos['tipo_habitacion'], 0, 1);

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(50, 7, 'Fecha de entrada:', 0, 0);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(0, 7, date('d/m/Y', strtotime($datos['fecha_entrada'])), 0, 1);

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(50, 7, 'Fecha de salida:', 0, 0);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(0, 7, date('d/m/Y', strtotime($datos['fecha_salida'])), 0, 1);

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(50, 7, 'Numero de personas:', 0, 0);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(0, 7, $datos['num_personas'], 0, 1);

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(50, 7, 'Metodo de pago:', 0, 0);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(0, 7, $datos['nombre_metodo'], 0, 1);

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(50, 7, 'Estado:', 0, 0);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(0, 7, ucfirst($datos['nombre_estado']), 0, 1);
$pdf->Ln(6);

// noches de estadia
$fechaEntrada = new DateTime($datos['fecha_entrada']);
$fechaSalida  = new DateTime($datos['fecha_salida']);
$noches       = $fechaEntrada->diff($fechaSalida)->days;

$pdf->SetFillColor(240, 235, 255);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 9, 'Resumen', 0, 1, 'L', true);
$pdf->Ln(2);

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(50, 7, 'Total de noches:', 0, 0);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(0, 7, $noches . ' noche(s)', 0, 1);
$pdf->Ln(8);

// footer
$pdf->SetFillColor(25, 0, 71);
$pdf->SetTextColor(255, 255, 255);
$pdf->SetFont('Arial', 'I', 9);
$pdf->Cell(0, 8, 'Hotel Paradise - Gracias por tu reservacion', 0, 1, 'C', true);
$pdf->Cell(0, 8, 'Generado el ' . date('d/m/Y H:i'), 0, 1, 'C', true);

$pdf->Output('D', 'reservacion_' . $datos['id'] . '.pdf');
