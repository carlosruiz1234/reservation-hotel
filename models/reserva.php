<?php
class Reserva {

    public function getHabitaciones() {
        $conexion = new Conexion();
        $conexion->conectar();
        $sql = "SELECT habitaciones.*, categorias.nombre AS categoria
                FROM habitaciones
                JOIN categorias ON habitaciones.id_categoria = categorias.id
                WHERE habitaciones.estado = 6";
        $conexion->query($sql);
        $result = $conexion->getResult();
        $conexion->desconectar();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getMetodosPago() {
        $conexion = new Conexion();
        $conexion->conectar();
        $sql = "SELECT * FROM metodos_pago";
        $conexion->query($sql);
        $result = $conexion->getResult();
        $conexion->desconectar();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function crearReserva($data) {
        $conexion = new Conexion();
        $conexion->conectar();
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
        // estado 3 = pendiente por defecto
        $conexion->query($sql);
        return $conexion->getFilasAfectadas();
    }

    public function getReservasPorUsuario($usuario_id) {
        $conexion = new Conexion();
        $conexion->conectar();
        $sql = "SELECT reservas.*, 
                       estado.nombre AS nombre_estado,
                       metodos_pago.nombre AS nombre_metodo
                FROM reservas
                JOIN estado ON reservas.estado = estado.id
                JOIN metodos_pago ON reservas.id_metodo_pago = metodos_pago.id
                WHERE reservas.usuario_id = '$usuario_id' 
                ORDER BY reservas.created_at DESC";
        $conexion->query($sql);
        $result = $conexion->getResult();
        $conexion->desconectar();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getReservaById($id) {
        $conexion = new Conexion();
        $conexion->conectar();
        $sql = "SELECT * FROM reservas WHERE id = '$id' LIMIT 1";
        $conexion->query($sql);
        $result = $conexion->getResult();
        $conexion->desconectar();
        return $result->fetch_assoc();
    }

    public function editarReserva($data) {
        $conexion = new Conexion();
        $conexion->conectar();
        $sql = "UPDATE reservas SET
                    tipo_habitacion = '{$data['tipo_habitacion']}',
                    fecha_entrada   = '{$data['fecha_entrada']}',
                    fecha_salida    = '{$data['fecha_salida']}',
                    num_personas    = '{$data['num_personas']}',
                    id_metodo_pago  = '{$data['id_metodo_pago']}'
                WHERE id = '{$data['id']}'
                AND usuario_id = '{$data['usuario_id']}'";
        $conexion->query($sql);
        return $conexion->getFilasAfectadas();
    }

    public function borrarReserva($id, $usuario_id) {
        $conexion = new Conexion();
        $conexion->conectar();
        $sql = "DELETE FROM reservas 
                WHERE id = '$id' 
                AND usuario_id = '$usuario_id'";
        $conexion->query($sql);
        return $conexion->getFilasAfectadas();
    }
}
?>
