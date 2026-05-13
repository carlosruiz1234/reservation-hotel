<?php
class excelController {

    public function generarExcel() {
    if (!isset($_SESSION['usuario'])) {
        header('Location: ' . SITE_URL . 'index.php?action=getFormLoginUser');
        exit;
    }

    require_once 'reportes/excelReserva.php';
    generarExcelReserva($_SESSION['usuario']['id']);
    exit;
}
}
