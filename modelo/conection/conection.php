<?php
class Database {
    private $host = "localhost";
    private $username = "root";
    private $password = ""; // cambiar la contraseña por la que tengan
    private $database = "dbintegrador";
    private $conn;

    public function connect() {
        try {
            $this->conn = new mysqli($this->host, $this->username, $this->password, $this->database); // Crear conexión
            
            if ($this->conn->connect_error) {
                throw new Exception("Connection failed: " . $this->conn->connect_error); // Agregado espacio por si la conexion llega a falla
            } 
            
            $this->conn->set_charset("utf8"); // Establecer el UTF-8
            return $this->conn; // Retornar la conexión
            
        } catch (Exception $e) {
            die("Error: " . $e->getMessage()); // Si sale error se muestra
        }
    }

    public function close() {
        if ($this->conn) {
            $this->conn->close();
        }
    }
}
?>
