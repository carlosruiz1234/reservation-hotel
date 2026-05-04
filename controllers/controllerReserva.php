<?php
require_once 'models/reserva.php';

class ControllerReserva {

    public function verDashboard() {
        if (!isset($_SESSION['usuario'])) {
            header('Location: ' . SITE_URL . 'index.php?action=getFormLoginUser');
            exit;
        }
        $reserva = new Reserva();
        $reservas = $reserva->getReservasPorUsuario($_SESSION['usuario']['id']);
        require_once 'views/html/dashboard/dashboard.php';
    }

    public function verFormReserva() {
        if (!isset($_SESSION['usuario'])) {
            header('Location: ' . SITE_URL . 'index.php?action=getFormLoginUser');
            exit;
        }
        $reserva = new Reserva();
        $categorias  = $reserva->getCategorias();
        $metodosPago = $reserva->getMetodosPago();
        require_once 'views/html/dashboard/formReserva.php';
    }

    public function getHabitacionesPorCategoria() {
        header('Content-Type: application/json');
        $id_categoria = $_GET['id_categoria'] ?? 0;
        $reserva = new Reserva();
        $habitaciones = $reserva->getHabitacionesPorCategoria($id_categoria);
        echo json_encode(['ok' => true, 'data' => $habitaciones]);
        exit;
    }

    public function crearReserva($datos) {
        if (!isset($_SESSION['usuario'])) {
            header('Location: ' . SITE_URL . 'index.php?action=getFormLoginUser');
            exit;
        }

        unset($_SESSION['errors'], $_SESSION['old']);

        $errores = $this->validateReserva($datos);

        if (count($errores) > 0) {
            $_SESSION['errors'] = $errores;
            $_SESSION['old'] = $datos;
            header('Location: ' . SITE_URL . 'index.php?action=getFormReserva');
            exit;
        }

        $datos['usuario_id'] = $_SESSION['usuario']['id'];

        $reserva = new Reserva();
        $resultado = $reserva->crearReserva($datos);

        if ($resultado > 0) {
            $_SESSION['success'] = '¡Reserva creada exitosamente!';
            header('Location: ' . SITE_URL . 'index.php?action=dashboard');
            exit;
        } else {
            $_SESSION['errors'] = ['general' => 'Error al crear la reserva.'];
            $_SESSION['old'] = $datos;
            header('Location: ' . SITE_URL . 'index.php?action=getFormReserva');
            exit;
        }
    }

    public function verFormEditarReserva($id) {
        if (!isset($_SESSION['usuario'])) {
            header('Location: ' . SITE_URL . 'index.php?action=getFormLoginUser');
            exit;
        }

        $reserva = new Reserva();
        $datosReserva = $reserva->getReservaById($id);

        if (!$datosReserva || $datosReserva['usuario_id'] != $_SESSION['usuario']['id']) {
            header('Location: ' . SITE_URL . 'index.php?action=dashboard');
            exit;
        }

        $categorias    = $reserva->getCategorias();
        $metodosPago   = $reserva->getMetodosPago();
        $categoriaActual = $reserva->getCategoriaDeHabitacion($datosReserva['tipo_habitacion']);

        require_once 'views/html/dashboard/formEditarReserva.php';
    }

    public function editarReserva($datos) {
        if (!isset($_SESSION['usuario'])) {
            header('Location: ' . SITE_URL . 'index.php?action=getFormLoginUser');
            exit;
        }

        unset($_SESSION['errors'], $_SESSION['old']);

        $errores = $this->validateReserva($datos);

        if (count($errores) > 0) {
            $_SESSION['errors'] = $errores;
            $_SESSION['old'] = $datos;
            header('Location: ' . SITE_URL . 'index.php?action=getFormEditarReserva&id=' . $datos['id']);
            exit;
        }

        $datos['usuario_id'] = $_SESSION['usuario']['id'];

        $reserva = new Reserva();
        $resultado = $reserva->editarReserva($datos);

        if ($resultado > 0) {
            $_SESSION['success'] = '¡Reserva actualizada!';
            header('Location: ' . SITE_URL . 'index.php?action=dashboard');
            exit;
        } else {
            $_SESSION['errors'] = ['general' => 'Error al actualizar la reserva.'];
            $_SESSION['old'] = $datos;
            header('Location: ' . SITE_URL . 'index.php?action=getFormEditarReserva&id=' . $datos['id']);// 
            exit;
        }
    }

    public function cancelarReserva($id) {
        if (!isset($_SESSION['usuario'])) {
            header('Location: ' . SITE_URL . 'index.php?action=getFormLoginUser');
            exit;
        }
        $reserva = new Reserva();
        $reserva->cancelarReserva($id, $_SESSION['usuario']['id']);
        $_SESSION['success'] = 'Reserva cancelada.';
        header('Location: ' . SITE_URL . 'index.php?action=dashboard');
        exit;
    }
    
    public function descargarPDF($id) {
    if (!isset($_SESSION['usuario'])) {
        header('Location: ' . SITE_URL . 'index.php?action=getFormLoginUser');
        exit;
    }

    $reserva = new Reserva();
    $datos = $reserva->getReservaCompletaById($id);

    if (!$datos || $datos['usuario_id'] != $_SESSION['usuario']['id']) {
        header('Location: ' . SITE_URL . 'index.php?action=dashboard');
        exit;
    }

    require_once __DIR__ . '/../reportes/fpdf186/fpdf.php'; 
    require_once 'reportes/pdfReserva.php';
    exit;
    }

    public function validateReserva($datos) {
        $errores = [];

        if (empty($datos['id_categoria'])) {
            $errores['id_categoria'] = 'El tipo de habitacion es requerido';
        }
        if (empty($datos['tipo_habitacion'])) {
            $errores['tipo_habitacion'] = 'La habitacion es requerida';
        }
        if (empty($datos['fecha_entrada'])) {
            $errores['fecha_entrada'] = 'La fecha de entrada es requerida';
        }
        if (empty($datos['fecha_salida'])) {
            $errores['fecha_salida'] = 'La fecha de salida es requerida';
        }
        if (!empty($datos['fecha_entrada']) && !empty($datos['fecha_salida'])) {
            if ($datos['fecha_salida'] <= $datos['fecha_entrada']) {
                $errores['fecha_salida'] = 'La fecha de salida debe ser despues de la entrada';
            }
        }
        if (empty($datos['num_personas'])) {
            $errores['num_personas'] = 'El numero de personas es requerido';
        } elseif ($datos['num_personas'] < 1 || $datos['num_personas'] > 10) {
            $errores['num_personas'] = 'Debe ser entre 1 y 10 personas';
        }
        if (empty($datos['id_metodo_pago'])) {
            $errores['id_metodo_pago'] = 'El metodo de pago es requerido';
        }

        return $errores;
    }
}
?>
