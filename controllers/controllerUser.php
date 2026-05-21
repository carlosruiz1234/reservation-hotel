<?php
session_start();
require_once 'models/user.php';

class ControllerUser {

    public function registerUser($datos) {
        unset($_SESSION['errors'], $_SESSION['old'], $_SESSION['success']);

        $errores = $this->validateData($datos);

        if (count($errores) > 0) {
            $_SESSION['errors'] = $errores;
            $_SESSION['old'] = $datos;
            header('Location: ' . SITE_URL . 'index.php?action=getFormRegisterUser');
            exit;
        }

        $user = new User();

        if ($user->validateUser($datos) > 0) {
            $_SESSION['errors'] = ['general' => 'El correo ya está registrado.'];
            $_SESSION['old'] = $datos;
            header('Location: ' . SITE_URL . 'index.php?action=getFormRegisterUser');
            exit;
        }

        if ($user->validateCedula($datos) > 0) {
            $_SESSION['errors'] = ['general' => 'La cédula ya está registrada.'];
            $_SESSION['old'] = $datos;
            header('Location: ' . SITE_URL . 'index.php?action=getFormRegisterUser');
            exit;
        }

        $datos['password'] = password_hash($datos['password'], PASSWORD_DEFAULT);
        $resultado = $user->registerUser($datos);

        if ($resultado > 0) {
            require_once 'controllers/controllerEmail.php';
            $emailCtrl = new controllerEmail();
            $emailCtrl->enviarBienvenida($datos['email'], $datos['name']);

            $_SESSION['success'] = '¡Cuenta creada! Ya puedes ingresar.';
            header('Location: ' . SITE_URL . 'index.php?action=getFormLoginUser');
            exit;
        } else {
            $_SESSION['errors'] = ['general' => 'Error al registrar. Inténtalo de nuevo.'];
            $_SESSION['old'] = $datos;
            header('Location: ' . SITE_URL . 'index.php?action=getFormRegisterUser');
            exit;
        }
    }

    public function loginUser($datos) {
        unset($_SESSION['errors'], $_SESSION['old'], $_SESSION['success']);

        if (empty($datos['email']) || empty($datos['password'])) {
            $_SESSION['errors']['general'] = 'Por favor completa todos los campos.';
            header('Location: ' . SITE_URL . 'index.php?action=getFormLoginUser');
            exit;
        }

        $user = new User();
        $resultado = $user->loginUser($datos);

        if ($resultado !== false) {
            $_SESSION['usuario'] = [
                'id'        => $resultado['id'],
                'name'      => $resultado['name'],
                'last_name' => $resultado['last_name'],
                'email'     => $resultado['email'],
                'role_id'   => $resultado['role_id']
            ];

            require_once 'controllers/ControllerEmail.php';
            $emailCtrl = new ControllerEmail();
            $emailCtrl->enviarLoginExitoso($resultado['email'], $resultado['name']);

            header('Location: ' . SITE_URL . 'index.php?action=dashboard');
            exit;
        } else {
            $_SESSION['errors']['general'] = 'Correo o contraseña incorrectos.';
            $_SESSION['old'] = $datos;
            header('Location: ' . SITE_URL . 'index.php?action=getFormLoginUser');
            exit;
        }
    }

    public function logout() {
        session_destroy();
        header('Location: ' . SITE_URL . 'index.php');
        exit;
    }

    public function verPaginaInicio($vista) {
        if ($vista == 'views/html/auth/register.php') {
            $user = new User();
            $documents = $user->getDocumentTypes();
        }
        require_once $vista;
    }

    public function validateData($datos) {
        $errores = [];

        if (!isset($datos['document_type_id']) || $datos['document_type_id'] === '') {
            $errores['document_type_id'] = 'El tipo de documento es requerido';
        }
        if (empty(trim($datos['document_number'] ?? ''))) {
            $errores['document_number'] = 'El numero de documento es requerido';
        } elseif (strlen($datos['document_number']) < 10) {
            $errores['document_number'] = 'Debe tener al menos 10 caracteres';
        } elseif (strlen($datos['document_number']) > 20) {
            $errores['document_number'] = 'No puede tener mas de 20 caracteres';
        } elseif (!preg_match('/^[0-9]+$/', $datos['document_number'])) {
            $errores['document_number'] = 'Solo puede contener numeros';
        }
        if (empty(trim($datos['name'] ?? ''))) {
            $errores['name'] = 'El nombre es requerido';
        } elseif (strlen($datos['name']) < 3) {
            $errores['name'] = 'Debe tener al menos 3 caracteres';
        } elseif (!preg_match('/^[a-zA-Z\s]+$/', $datos['name'])) {
            $errores['name'] = 'Solo puede contener letras';
        }
        if (empty(trim($datos['last_name'] ?? ''))) {
            $errores['last_name'] = 'El apellido es requerido';
        } elseif (strlen($datos['last_name']) < 3) {
            $errores['last_name'] = 'Debe tener al menos 3 caracteres';
        } elseif (!preg_match('/^[a-zA-Z\s]+$/', $datos['last_name'])) {
            $errores['last_name'] = 'Solo puede contener letras';
        }
        if (empty(trim($datos['phone'] ?? ''))) {
            $errores['phone'] = 'El telefono es requerido';
        } elseif (!preg_match('/^[0-9]+$/', $datos['phone'])) {
            $errores['phone'] = 'Solo puede contener numeros';
        } elseif (strlen($datos['phone']) < 10 || strlen($datos['phone']) > 10) {
            $errores['phone'] = 'Debe tener exactamente 10 digitos';
        }
        if (empty(trim($datos['email'] ?? ''))) {
            $errores['email'] = 'El email es requerido';
        } elseif (!filter_var($datos['email'], FILTER_VALIDATE_EMAIL)) {
            $errores['email'] = 'El email no es valido';
        }
        $password = $datos['password'] ?? '';
        if (empty($password)) {
            $errores['password'] = 'La contrasena es requerida';
        } elseif (strlen($password) < 6) {
            $errores['password'] = 'Minimo 6 caracteres';
        } elseif (!preg_match('/[A-Z]/', $password)) {
            $errores['password'] = 'Debe tener al menos una mayuscula';
        } elseif (!preg_match('/[a-z]/', $password)) {
            $errores['password'] = 'Debe tener al menos una minuscula';
        } elseif (!preg_match('/[0-9]/', $password)) {
            $errores['password'] = 'Debe tener al menos un numero';
        } elseif (!preg_match('/[^A-Za-z0-9]/', $password)) {
            $errores['password'] = 'Debe tener al menos un caracter especial (!@#$%...)';
        }
        if (empty($datos['confirmar_password'] ?? '')) {
            $errores['confirmar_password'] = 'Confirmar contrasena es requerida';
        } elseif ($datos['confirmar_password'] !== $password) {
            $errores['confirmar_password'] = 'Las contrasenas no coinciden';
        }

        return $errores;
    }
}
?>