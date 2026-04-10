<?php
session_start();
require_once 'models/user.php';

class ControllerBase {

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
        $existe = $user->validateUser($datos);
        if ($existe > 0) {
            $_SESSION['errors'] = ['general' => 'El correo ya está registrado.'];
            $_SESSION['old'] = $datos;
            header('Location: ' . SITE_URL . 'index.php?action=getFormRegisterUser');
            exit;
        }

        $datos['password'] = password_hash($datos['password'], PASSWORD_DEFAULT);

        $resultado = $user->registerUser($datos);

        if ($resultado > 0) {
            $_SESSION['success'] = '¡Cuenta creada! Ya puedes ingresar.';
            header('Location: ' . SITE_URL . 'index.php?action=getFormLoginUser');
            exit;
        } else {
            $_SESSION['errors'] = ['general' => 'Error al registrar el usuario. Inténtalo de nuevo.'];
            $_SESSION['old'] = $datos;
            header('Location: ' . SITE_URL . 'index.php?action=getFormRegisterUser');
            exit;
        }
    }

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
            header('Location: ' . SITE_URL . 'index.php');
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


    public function validateData($datos) {
        $errores = [];

        if (!isset($datos['document_type_id']) || $datos['document_type_id'] === '') {
            $errores['document_type_id'] = 'El tipo de documento es requerido';
        }
        //_______
        if (empty(trim($datos['document_number'] ?? ''))) {
            $errores['document_number'] = 'El numero de documento es requerido';
        }
        elseif (strlen($datos['document_number']) > 20){
            $errores['document_number'] = 'El numero de documento no puede tener mas de 20 caracteres';
        }
        elseif (!preg_match('/^[0-9]+$/', $datos['document_number'])) {
            $errores['document_number'] = 'El numero de documento solo puede contener números';
        }
        //_______
        if (empty(trim($datos['name'] ?? ''))) {
            $errores['name'] = 'El nombre es requerido';
        }
        elseif (!preg_match('/^[a-zA-Z\s]+$/', $datos['name'])) {
            $errores['name'] = 'El nombre solo puede contener letras';
        }
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
        return $errores;
    }

    public function verPaginaInicio($vista) {
        require_once $vista;
    }
}

?>