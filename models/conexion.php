<?php
class Conexion {
    private $mySQLI;
    private $sql;
    private $result;
    private $filasAfectadas;

    public function conectar(){
        $host = 'localhost';
        $db = 'hotel_reservas';
        $user = 'root';
        $password = '';

        $this->mySQLI = new mysqli($host, $user, $password, $db);

        if($this->mySQLI->connect_error){

            throw new Exception('Error de conexión a la base de datos: ' . $this->mySQLI->connect_error);
        }


       // echo "Conectado a la base de datos";

        echo "Conectado a la base de datos";

    }

    public function desconectar(){
        $this->mySQLI->close();
    }

    public function query($sql){
        $this->sql = $sql;
        $this->result = $this->mySQLI->query($sql);
        $this->filasAfectadas = $this->mySQLI->affected_rows;
    }

    public function getResult(){
        return $this->result;
    }

    public function getFilasAfectadas(){
        return $this->filasAfectadas;
    }
}
?>
