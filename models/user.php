<?php
class User {

    private function conectar() {
        $mysqli = new mysqli('localhost', 'root', '', 'hotel_reservas');
        if ($mysqli->connect_error) {
            die('Error de conexion: ' . $mysqli->connect_error);
        }
        return $mysqli;
    }

    public function validateUser($data) {
        $db = $this->conectar();
        $sql = "SELECT * FROM usuarios WHERE email = '{$data['email']}'";
        $result = $db->query($sql);
        $db->close();
        return $result->num_rows > 0 ? 1 : 0;
    }

    public function validateCedula($data) {
        $db = $this->conectar();
        $sql = "SELECT * FROM usuarios WHERE document_number = '{$data['document_number']}'";
        $result = $db->query($sql);
        $db->close();
        return $result->num_rows > 0 ? 1 : 0;
    }

    public function registerUser($data) {
        $db = $this->conectar();
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
        $db->query($sql);
        $filas = $db->affected_rows;
        $db->close();
        return $filas;
    }

    public function loginUser($data) {
        $db = $this->conectar();
        $sql = "SELECT * FROM usuarios WHERE email = '{$data['email']}' LIMIT 1";
        $result = $db->query($sql);
        $db->close();
        if ($result->num_rows > 0) {
            $usuario = $result->fetch_assoc();
            if (password_verify($data['password'], $usuario['password'])) {
                return $usuario;
            }
        }
        return false;
    }

    public function getDocumentTypes() {
        $db = $this->conectar();
        $sql = "SELECT * FROM document_types";
        $result = $db->query($sql);
        $db->close();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>
