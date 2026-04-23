<?php

require_once 'controllers/controllerBase.php';
require_once 'config/config.php';
require_once 'models/conexion.php';

$controllerBase = new ControllerBase();

// Enrutador
if(isset($_GET['action'])){

    if($_GET['action'] == 'getFormRegisterUser'){
        $controllerBase->verPaginaInicio('views/html/auth/register.php');
    }
    elseif($_GET['action'] == 'registerUser'){
        $controllerBase->registerUser($_POST);
    }
    elseif($_GET['action'] == 'getFormLoginUser'){
        $controllerBase->verPaginaInicio('views/html/auth/login.php');
    }
    elseif($_GET['action'] == 'loginUser'){
        $controllerBase->loginUser($_POST);
    }
    elseif($_GET['action'] == 'logout'){
        $controllerBase->logout();
    }

    elseif($_GET['action'] == 'dashboard'){
        $controllerBase->verDashboard();
    }
    elseif($_GET['action'] == 'getFormReserva'){
        $controllerBase->verFormReserva();
    }
    elseif($_GET['action'] == 'crearReserva'){
        $controllerBase->crearReserva($_POST);   
    }
    elseif($_GET['action'] == 'getFormEditarReserva'){
        $controllerBase->verFormEditarReserva($_GET['id']);
    }
    elseif($_GET['action'] == 'editarReserva'){
        $controllerBase->editarReserva($_POST);
    }
    elseif($_GET['action'] == 'borrarReserva'){
        $controllerBase->borrarReserva($_GET['id']);
    }
=======


} else {
    $controllerBase->verPaginaInicio('views/html/home.php');
}
?>
