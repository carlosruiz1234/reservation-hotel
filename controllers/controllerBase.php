<?php
session_start();
require_once 'models/user.php';
<<<<<<< HEAD
require_once 'models/reserva.php';

class ControllerBase {

    // ============ function register ============
=======

class ControllerBase {

>>>>>>> e6694ff46042b2494fef28f3f18d4e126e6eaeea
    public function registerUser($datos) {
        unset($_SESSION['errors']);
        unset($_SESSION['old']);
        unset($_SESSION['success']);

        $errores = $this->validateData($datos);

        if (count($errores) > 0) {
            $_SESSION['errors'] = $errores;
            $_SESSION['old'] = $datos;
            header('Location: ' . SITE_URL . 'index.php?action=getFormRegisterUser');
            exit;
        }

        $user = new User();
<<<<<<< HEAD

=======
>>>>>>> e6694ff46042b2494fef28f3f18d4e126e6eaeea
        $existe = $user->validateUser($datos);
        if ($existe > 0) {
            $_SESSION['errors'] = ['general' => 'El correo ya está registrado.'];
            $_SESSION['old'] = $datos;
            header('Location: ' . SITE_URL . 'index.php?action=getFormRegisterUser');
            exit;
        }

<<<<<<< HEAD
        $cedulaExiste = $user->validateCedula($datos);
        if ($cedulaExiste > 0) {
            $_SESSION['errors'] = ['general' => 'La cédula ya está registrada.'];
            $_SESSION['old'] = $datos;
            header('Location: ' . SITE_URL . 'index.php?action=getFormRegisterUser');
            exit;
        }

        $datos['password'] = password_hash($datos['password'], PASSWORD_DEFAULT);
=======
        $datos['password'] = password_hash($datos['password'], PASSWORD_DEFAULT);

>>>>>>> e6694ff46042b2494fef28f3f18d4e126e6eaeea
        $resultado = $user->registerUser($datos);

        if ($resultado > 0) {
            $_SESSION['success'] = '¡Cuenta creada! Ya puedes ingresar.';
            header('Location: ' . SITE_URL . 'index.php?action=getFormLoginUser');
            exit;
        } else {
<<<<<<< HEAD
            $_SESSION['errors'] = ['general' => 'Error al registrar el usuario.'];
=======
            $_SESSION['errors'] = ['general' => 'Error al registrar el usuario. Inténtalo de nuevo.'];
>>>>>>> e6694ff46042b2494fef28f3f18d4e126e6eaeea
            $_SESSION['old'] = $datos;
            header('Location: ' . SITE_URL . 'index.php?action=getFormRegisterUser');
            exit;
        }
    }

<<<<<<< HEAD
    // ============ cuando se valla a logear se llama la funcion ============
=======
>>>>>>> e6694ff46042b2494fef28f3f18d4e126e6eaeea
    public function loginUser($datos) {
        unset($_SESSION['errors']);
        unset($_SESSION['old']);
        unset($_SESSION['success']);

        if(empty($datos['email']) || empty($datos['password'])) {
            $_SESSION['errors']['general'] = 'Por favor completa todos los campos.';
            header('Location: ' . SITE_URL . 'index.php?action=getFormLoginUser');
            exit;
        }

        $user = new User();
        $resultado = $user->loginUser($datos);

        if($resultado !== false) {
            $_SESSION['usuario'] = [
                'id'        => $resultado['id'],
                'name'      => $resultado['name'],
                'last_name' => $resultado['last_name'],
                'email'     => $resultado['email'],
                'role_id'   => $resultado['role_id']
            ];
<<<<<<< HEAD
            header('Location: ' . SITE_URL . 'index.php?action=dashboard');
=======
            header('Location: ' . SITE_URL . 'index.php');
>>>>>>> e6694ff46042b2494fef28f3f18d4e126e6eaeea
            exit;
        } else {
            $_SESSION['errors']['general'] = 'Correo o contraseña incorrectos.';
            $_SESSION['old'] = $datos;
            header('Location: ' . SITE_URL . 'index.php?action=getFormLoginUser');
            exit;
        }
    }

<<<<<<< HEAD
    // ============ para poder ir al dashboars se usa esta funcion ============
    public function verDashboard() {
        if(!isset($_SESSION['usuario'])) {
            header('Location: ' . SITE_URL . 'index.php?action=getFormLoginUser');
            exit;
        }
        $reserva = new Reserva();
        $reservas = $reserva->getReservasPorUsuario($_SESSION['usuario']['id']);
        require_once 'views/html/dashboard.php';
    }

    // ============ para poder ver la reseerva ============
    public function verFormReserva() {
        if(!isset($_SESSION['usuario'])) {
            header('Location: ' . SITE_URL . 'index.php?action=getFormLoginUser');
            exit;
        }
        
        $reserva = new Reserva();
        $habitaciones = $reserva->getHabitaciones();
        $metodosPago  = $reserva->getMetodosPago();
        require_once 'views/html/reserva/form_reserva.php';
    }

    // ============ esto permite crear la reserva============
    public function crearReserva($datos) {
        if(!isset($_SESSION['usuario'])) {
            header('Location: ' . SITE_URL . 'index.php?action=getFormLoginUser');
            exit;
        }

        unset($_SESSION['errors']);
        unset($_SESSION['old']);

        $errores = $this->validateReserva($datos);

        if(count($errores) > 0) {
            $_SESSION['errors'] = $errores;
            $_SESSION['old'] = $datos;
            header('Location: ' . SITE_URL . 'index.php?action=getFormReserva');
            exit;
        }

        $datos['usuario_id'] = $_SESSION['usuario']['id'];

        $reserva = new Reserva();
        $resultado = $reserva->crearReserva($datos);

        if($resultado > 0) {
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

    // ============para poder ver el otro formulario de edicion de reserva ============
    public function verFormEditarReserva($id) {
        if(!isset($_SESSION['usuario'])) {
            header('Location: ' . SITE_URL . 'index.php?action=getFormLoginUser');
            exit;
        }

        $reserva = new Reserva();
        $datosReserva = $reserva->getReservaById($id);

        if(!$datosReserva || $datosReserva['usuario_id'] != $_SESSION['usuario']['id']) {
            header('Location: ' . SITE_URL . 'index.php?action=dashboard');
            exit;
        }


        $habitaciones = $reserva->getHabitaciones();
        $metodosPago  = $reserva->getMetodosPago();

        require_once 'views/html/reserva/form_editar_reserva.php';
    }

    // ============ aqui permite editar la reserva ============
    public function editarReserva($datos) {
        if(!isset($_SESSION['usuario'])) {
            header('Location: ' . SITE_URL . 'index.php?action=getFormLoginUser');
            exit;
        }

        unset($_SESSION['errors']);
        unset($_SESSION['old']);

        $errores = $this->validateReserva($datos);

        if(count($errores) > 0) {
            $_SESSION['errors'] = $errores;
            $_SESSION['old'] = $datos;
            header('Location: ' . SITE_URL . 'index.php?action=getFormEditarReserva&id=' . $datos['id']);
            exit;
        }

        $datos['usuario_id'] = $_SESSION['usuario']['id'];

        $reserva = new Reserva();
        $resultado = $reserva->editarReserva($datos);

        if($resultado > 0) {
            $_SESSION['success'] = '¡Reserva actualizada exitosamente!';
            header('Location: ' . SITE_URL . 'index.php?action=dashboard');
            exit;
        } else {
            $_SESSION['errors'] = ['general' => 'Error al actualizar la reserva.'];
            $_SESSION['old'] = $datos;
            header('Location: ' . SITE_URL . 'index.php?action=getFormEditarReserva&id=' . $datos['id']);
            exit;
        }
    }

    // ============ BORRAR RESERVA ============
    public function borrarReserva($id) {
        if(!isset($_SESSION['usuario'])) {
            header('Location: ' . SITE_URL . 'index.php?action=getFormLoginUser');
            exit;
        }
        $reserva = new Reserva();
        $reserva->borrarReserva($id, $_SESSION['usuario']['id']);
        $_SESSION['success'] = 'Reserva eliminada.';
        header('Location: ' . SITE_URL . 'index.php?action=dashboard');
        exit;
    }

    // ============ permite salir y destruir la sesion ============
=======
>>>>>>> e6694ff46042b2494fef28f3f18d4e126e6eaeea
    public function logout() {
        session_destroy();
        header('Location: ' . SITE_URL . 'index.php');
        exit;
    }

<<<<<<< HEAD
    // ============ validaciones ============
    public function validateReserva($datos) {
        $errores = [];

        if(empty($datos['tipo_habitacion'])) {
            $errores['tipo_habitacion'] = 'La habitación es requerida';
        }
        if(empty($datos['fecha_entrada'])) {
            $errores['fecha_entrada'] = 'La fecha de entrada es requerida';
        }
        if(empty($datos['fecha_salida'])) {
            $errores['fecha_salida'] = 'La fecha de salida es requerida';
        }
        if(!empty($datos['fecha_entrada']) && !empty($datos['fecha_salida'])) {
            if($datos['fecha_salida'] <= $datos['fecha_entrada']) {
                $errores['fecha_salida'] = 'La fecha de salida debe ser después de la entrada';
            }
        }
        if(empty($datos['num_personas'])) {
            $errores['num_personas'] = 'El número de personas es requerido';
        }
        elseif($datos['num_personas'] < 1 || $datos['num_personas'] > 10) {
            $errores['num_personas'] = 'El número de personas debe ser entre 1 y 10';
        }
        if(empty($datos['id_metodo_pago'])) {
            $errores['id_metodo_pago'] = 'El método de pago es requerido';
        }

        return $errores;
    }

    // ============ val usuario ============
=======

>>>>>>> e6694ff46042b2494fef28f3f18d4e126e6eaeea
    public function validateData($datos) {
        $errores = [];

        if (!isset($datos['document_type_id']) || $datos['document_type_id'] === '') {
            $errores['document_type_id'] = 'El tipo de documento es requerido';
        }
<<<<<<< HEAD
=======
        //_______
>>>>>>> e6694ff46042b2494fef28f3f18d4e126e6eaeea
        if (empty(trim($datos['document_number'] ?? ''))) {
            $errores['document_number'] = 'El numero de documento es requerido';
        }
        elseif (strlen($datos['document_number']) > 20){
            $errores['document_number'] = 'El numero de documento no puede tener mas de 20 caracteres';
        }
        elseif (!preg_match('/^[0-9]+$/', $datos['document_number'])) {
            $errores['document_number'] = 'El numero de documento solo puede contener números';
        }
<<<<<<< HEAD
=======
        //_______
>>>>>>> e6694ff46042b2494fef28f3f18d4e126e6eaeea
        if (empty(trim($datos['name'] ?? ''))) {
            $errores['name'] = 'El nombre es requerido';
        }
        elseif (!preg_match('/^[a-zA-Z\s]+$/', $datos['name'])) {
            $errores['name'] = 'El nombre solo puede contener letras';
        }
<<<<<<< HEAD
        if (empty(trim($datos['last_name'] ?? ''))) {
            $errores['last_name'] = 'El apellido es requerido';
        }
        elseif (!preg_match('/^[a-zA-Z\s]+$/', $datos['last_name'])) {
            $errores['last_name'] = 'El apellido solo puede contener letras';
        }
        if (empty(trim($datos['phone'] ?? ''))) {
            $errores['phone'] = 'El telefono es requerido';
        }
        elseif (!preg_match('/^[0-9]+$/', $datos['phone'])) {
            $errores['phone'] = 'El telefono solo puede contener números';
        }
        elseif (strlen($datos['phone']) > 10){
            $errores['phone'] = 'El telefono no puede tener mas de 10 caracteres';
        }
        if (empty(trim($datos['email'] ?? ''))) {
            $errores['email'] = 'El email es requerido';
        }
        elseif (!filter_var($datos['email'], FILTER_VALIDATE_EMAIL)) {
            $errores['email'] = 'El email no es válido';
        }
        $password = $datos['password'] ?? '';
        if (empty($password)) {
            $errores['password'] = 'La contraseña es requerida';
        }
        elseif (strlen($password) < 6) {
            $errores['password'] = 'La contraseña debe tener al menos 6 caracteres';
        }
        elseif (!preg_match('/[A-Z]/', $password)) {
            $errores['password'] = 'La contraseña debe tener al menos una letra mayúscula';
        }
        elseif (!preg_match('/[a-z]/', $password)) {
            $errores['password'] = 'La contraseña debe tener al menos una letra minúscula';
        }
        elseif (!preg_match('/[0-9]/', $password)) {
            $errores['password'] = 'la contraseña debe tener al menos un numero';
        }
        elseif (!preg_match('/[^A-Za-z0-9]/', $password)) {
            $errores['password'] = 'La contraseña debe tener al menos un carácter especial';
        }
        if (empty($datos['confirmar-password'] ?? '')){
            $errores['confirmar-password'] = 'Confirmar contraseña es requerida';
        }
        elseif (($datos['confirmar-password']) !== ($datos['password'])){
            $errores['confirmar-password'] = 'Las contraseñas no coinciden';
        }

=======
        //______
        if (empty(trim($datos['last_name'] ?? ''))) {
            $errores['last_name'] = 'El apellido es requerido';
        }elseif (!preg_match('/^[a-zA-Z\s]+$/', $datos['last_name'])) {
            $errores['last_name'] = 'El apellido solo puede contener letras';
        }
        //______
        if (empty(trim($datos['phone'] ?? ''))) {
            $errores['phone'] = 'El telefono es requerido';
        }elseif (!preg_match('/^[0-9]+$/', $datos['phone'])) {
            $errores['phone'] = 'El telefono solo puede contener números';
        }elseif (strlen($datos['phone']) > 10){
            $errores['phone'] = 'El telefono no puede tener mas de 10 caracteres';
        }
        //_______
        if (empty(trim($datos['email'] ?? ''))) {
            $errores['email'] = 'El email es requerido';
        } elseif (!filter_var($datos['email'], FILTER_VALIDATE_EMAIL)) {
            $errores['email'] = 'El email no es válido';
        }
        //contra
        $password = $datos['password'] ?? '';
        if (empty($password)) {
            $errores['password'] = 'La contraseña es requerida';
        } elseif (strlen($password) < 6) {
            $errores['password'] = 'La contraseña debe tener al menos 6 caracteres';
        } elseif (!preg_match('/[A-Z]/', $password)) {
            $errores['password'] = 'La contraseña debe tener al menos una letra mayúscula';
        } elseif (!preg_match('/[a-z]/', $password)) {
            $errores['password'] = 'La contraseña debe tener al menos una letra minúscula';
        }elseif (!preg_match('/[0-9]/', $password)) {
            $errores['password'] = 'la contraseña debe tener al menos un numero';
        }elseif (!preg_match('/[^A-Za-z0-9]/', $password)) {
            $errores['password'] = 'La contraseña debe tener al menos un carácter especial (!@#$%...)';
        }
        // confir
        if (empty($datos['confirmar-password'] ?? '')){
            $errores['confirmar-password'] = 'cofirmar contraseña es requerida';
        }elseif (($datos['confirmar-password']) !== ($datos['password'])){
            $errores['confirmar-password'] = 'las contraseñas no coinciden';
        }
>>>>>>> e6694ff46042b2494fef28f3f18d4e126e6eaeea
        return $errores;
    }

    public function verPaginaInicio($vista) {
<<<<<<< HEAD
        if($vista == 'views/html/auth/register.php') {
            $user = new User();
            $documents = $user->getDocumentTypes();
        }
        require_once $vista;
    }
}
?>
=======
        require_once $vista;
    }
}

?>
>>>>>>> e6694ff46042b2494fef28f3f18d4e126e6eaeea
