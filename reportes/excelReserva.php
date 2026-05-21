<?php
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

require_once 'models/reserva.php';

function generarExcelReserva($usuarioId) {
    $reservaModel = new Reserva();
    $reservas     = $reservaModel->getTodasLasReservasPorUsuario($usuarioId);

    $spreadsheet = new Spreadsheet();
    $sheet       = $spreadsheet->getActiveSheet();
    $sheet->setTitle('Mis Reservaciones');


    $sheet->mergeCells('A1:G1');
    $sheet->setCellValue('A1', 'Hotel Blox — Mis Reservaciones');
    $sheet->getStyle('A1')->applyFromArray([
        'font'      => ['bold' => true, 'size' => 14, 'color' => ['rgb' => 'FFFFFF'], 'name' => 'Arial'],
        'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '190047']],
        'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
    ]);
    $sheet->getRowDimension(1)->setRowHeight(28);


    $headers = ['#', 'Habitación', 'Fecha Entrada', 'Fecha Salida', 'Personas', 'Método Pago', 'Estado'];
    $col = 'A';
    foreach ($headers as $h) {
        $sheet->setCellValue($col . '2', $h);
        $col++;
    }
    $sheet->getStyle('A2:G2')->applyFromArray([
        'font'      => ['bold' => true, 'size' => 11, 'color' => ['rgb' => 'FFFFFF'], 'name' => 'Arial'],
        'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '6f42c1']],
        'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'FFFFFF']]],
    ]);
    $sheet->getRowDimension(2)->setRowHeight(20);


    $fila = 3;
    foreach ($reservas as $r) {
        $sheet->setCellValue('A' . $fila, $r['id']);
        $sheet->setCellValue('B' . $fila, $r['tipo_habitacion']);
        $sheet->setCellValue('C' . $fila, date('d/m/Y', strtotime($r['fecha_entrada'])));
        $sheet->setCellValue('D' . $fila, date('d/m/Y', strtotime($r['fecha_salida'])));
        $sheet->setCellValue('E' . $fila, $r['num_personas']);
        $sheet->setCellValue('F' . $fila, $r['nombre_metodo']);
        $sheet->setCellValue('G' . $fila, ucfirst($r['nombre_estado']));


        $bg = ($fila % 2 === 0) ? 'F0EBFF' : 'FFFFFF';
        $sheet->getStyle("A{$fila}:G{$fila}")->applyFromArray([
            'font'      => ['size' => 10, 'name' => 'Arial'],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => $bg]],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'DDDDDD']]],
        ]);

        $fila++;
    }


    $sheet->getColumnDimension('A')->setWidth(6);
    $sheet->getColumnDimension('B')->setWidth(18);
    $sheet->getColumnDimension('C')->setWidth(15);
    $sheet->getColumnDimension('D')->setWidth(15);
    $sheet->getColumnDimension('E')->setWidth(10);
    $sheet->getColumnDimension('F')->setWidth(18);
    $sheet->getColumnDimension('G')->setWidth(14);


    $writer = new Xlsx($spreadsheet);
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="mis_reservaciones.xlsx"');
    header('Cache-Control: max-age=0');
    $writer->save('php://output');
    exit;
}