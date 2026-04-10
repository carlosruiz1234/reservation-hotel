<?php
class User {

    public function validateUser($data) {
        $conexion = new Conexion();
        $conexion->conectar();
        $sql = "SELECT * FROM usuarios WHERE email = '{$data['email']}'";
        $conexion->query($sql);
        $result = $conexion->getResult();
        $conexion->desconectar();
        if ($result->num_rows > 0) {
            return 1;
        }
        return 0;
    }

    public function validateCedula($data) {
        $conexion = new Conexion();
        $conexion->conectar();
        $sql = "SELECT * FROM usuarios WHERE document_number = '{$data['document_number']}'";
        $conexion->query($sql);
        $result = $conexion->getResult();
        $conexion->desconectar();
        if ($result->num_rows > 0) {
            return 1;
        }
        return 0;
    }

    public function registerUser($data) {
        $conexion = new Conexion();
        $conexion->conectar();
        $sql = "INSERT INTO usuarios 
                (document_type_id, document_number, name, last_name, phone, email, password, role_id)
                VALUES (
                    '{$data['document_type_id']}',
                    '{$data['document_number']}',
                    '{$data['name']}',
                    '{$data['last_name']}',
                    '{$data['phone']}',
                    '{$data['email']}',
                    '{$data['password']}',
                    '{$data['role_id']}')";
        $conexion->query($sql);
        return $conexion->getFilasAfectadas();
    }

    public function loginUser($data) {
        $conexion = new Conexion();
        $conexion->conectar();
        $email = $data['email'];
        $sql = "SELECT * FROM usuarios WHERE email = '$email' LIMIT 1";
        $conexion->query($sql);
        $result = $conexion->getResult();
        $conexion->desconectar();

        if ($result->num_rows > 0) {
            $usuario = $result->fetch_assoc();
            if (password_verify($data['password'], $usuario['password'])) {
                return $usuario; // login correcto
            }
        }
        return false; 
    }
}
?>
