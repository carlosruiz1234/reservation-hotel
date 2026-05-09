<?php

require_once 'config/config.php';
require_once 'models/user.php';
require_once 'models/reserva.php';
require_once 'controllers/controllerUser.php';
require_once 'controllers/controllerReserva.php';
require_once 'controllers/controllerExcel.php';

$user    = new ControllerUser();
$reserva = new ControllerReserva();
$excel   = new excelController();

if (isset($_GET['action'])) {

    if ($_GET['action'] == 'getFormRegisterUser') {
        $user->verPaginaInicio('views/html/auth/register.php');
    } elseif ($_GET['action'] == 'registerUser') {
        $user->registerUser($_POST);
    } elseif ($_GET['action'] == 'getFormLoginUser') {
        $user->verPaginaInicio('views/html/auth/login.php');
    } elseif ($_GET['action'] == 'loginUser') {
        $user->loginUser($_POST);
    } elseif ($_GET['action'] == 'logout') {
        $user->logout();
    } elseif ($_GET['action'] == 'dashboard') {
        $reserva->verDashboard();
    } elseif ($_GET['action'] == 'getFormReserva') {
        $reserva->verFormReserva();
    } elseif ($_GET['action'] == 'crearReserva') {
        $reserva->crearReserva($_POST);
    } elseif ($_GET['action'] == 'getFormEditarReserva') {
        $reserva->verFormEditarReserva($_GET['id']);
    } elseif ($_GET['action'] == 'editarReserva') {
        $reserva->editarReserva($_POST);
    } elseif ($_GET['action'] == 'cancelarReserva') {
        $reserva->cancelarReserva($_GET['id']);
    } elseif ($_GET['action'] == 'getHabitacionesPorCategoria') {
        $reserva->getHabitacionesPorCategoria();
    } elseif ($_GET['action'] == 'descargarPDF') {
        $reserva->descargarPDF($_GET['id']);
    } elseif ($_GET['action'] == 'generarExcel'){
        $excel->generarExcel();
    } else {
        $user->verPaginaInicio('views/html/home.php');
    }
}else{  
        $user->verPaginaInicio('views/html/home.php');
    }
?>  
