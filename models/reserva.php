<?php
class Reserva {

    private function conectar() {
        $mysqli = new mysqli('localhost', 'root', '', 'hotel_reservas');
        if ($mysqli->connect_error) {
            die('Error de conexion: ' . $mysqli->connect_error);
        }
        return $mysqli;
    }

    public function getCategorias() {
        $db = $this->conectar();
        $result = $db->query("SELECT * FROM categorias");
        $db->close();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getHabitacionesPorCategoria($id_categoria) {
        $db = $this->conectar();
        $id_categoria = (int) $id_categoria;// sanitizar la entrada 
        $sql = "SELECT * FROM habitaciones 
                WHERE id_categoria = $id_categoria 
                AND estado = 6
                ORDER BY num_habitacion ASC";
        $result = $db->query($sql);
        $db->close();
        return $result->fetch_all(MYSQLI_ASSOC);// lo convierte en un array asociativo
    }

    public function getMetodosPago() {
        $db = $this->conectar();
        $result = $db->query("SELECT * FROM metodos_pago");
        $db->close();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function crearReserva($data) {
        $db = $this->conectar();
        $sql = "INSERT INTO reservas 
                (usuario_id, tipo_habitacion, fecha_entrada, fecha_salida, num_personas, id_metodo_pago, estado)
                VALUES (
                    '{$data['usuario_id']}',
                    '{$data['tipo_habitacion']}',
                    '{$data['fecha_entrada']}',
                    '{$data['fecha_salida']}',
                    '{$data['num_personas']}',
                    '{$data['id_metodo_pago']}',
                    3)";
        $db->query($sql);
        $filas = $db->affected_rows;
        $db->close();
        return $filas;
    }

    public function getReservasPorUsuario($usuario_id) {
        $db = $this->conectar();
        $sql = "SELECT reservas.*, 
                       estado.nombre AS nombre_estado,
                       metodos_pago.nombre AS nombre_metodo
                FROM reservas
                JOIN estado ON reservas.estado = estado.id
                JOIN metodos_pago ON reservas.id_metodo_pago = metodos_pago.id
                WHERE reservas.usuario_id = '$usuario_id' 
                ORDER BY reservas.created_at DESC";
        $result = $db->query($sql);
        $db->close();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getReservaById($id) {
        $db = $this->conectar();
        $sql = "SELECT * FROM reservas WHERE id = '$id' LIMIT 1";
        $result = $db->query($sql);
        $db->close();
        return $result->fetch_assoc();
    }

    public function editarReserva($data) {
        $db = $this->conectar();
        $sql = "UPDATE reservas SET
                    tipo_habitacion = '{$data['tipo_habitacion']}',
                    fecha_entrada   = '{$data['fecha_entrada']}',
                    fecha_salida    = '{$data['fecha_salida']}',
                    num_personas    = '{$data['num_personas']}',
                    id_metodo_pago  = '{$data['id_metodo_pago']}'
                WHERE id = '{$data['id']}'
                AND usuario_id = '{$data['usuario_id']}'";
        $db->query($sql);
        $filas = $db->affected_rows;
        $db->close();
        return $filas;
    }

    public function cancelarReserva($id, $usuario_id) {
        $db = $this->conectar();
        $sql = "UPDATE reservas SET estado = 5
                WHERE id = '$id' 
                AND usuario_id = '$usuario_id'";
        $db->query($sql);
        $filas = $db->affected_rows;
        $db->close();
        return $filas;
    }
    public function getReservaCompletaById($id) {
        $db = $this->conectar();
        $sql = "SELECT reservas.*,
                    estado.nombre AS nombre_estado,
                    metodos_pago.nombre AS nombre_metodo,
                    usuarios.name AS usuario_nombre,
                    usuarios.last_name AS usuario_apellido,
                    usuarios.email AS usuario_email,
                    usuarios.phone AS usuario_telefono
                FROM reservas
                JOIN estado ON reservas.estado = estado.id
                JOIN metodos_pago ON reservas.id_metodo_pago = metodos_pago.id
                JOIN usuarios ON reservas.usuario_id = usuarios.id
                WHERE reservas.id = '$id' LIMIT 1";
        $result = $db->query($sql);
        $db->close();
        return $result->fetch_assoc();
    
    }

    public function getCategoriaDeHabitacion($num_habitacion) {
        $db = $this->conectar();
        $sql = "SELECT id_categoria FROM habitaciones 
                WHERE num_habitacion = '$num_habitacion' LIMIT 1";
        $result = $db->query($sql);
        $db->close();
        $fila = $result->fetch_assoc();
        return $fila ? $fila['id_categoria'] : null;
    }
}
?>
