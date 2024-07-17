<?php

// POO
class Clase_Conectar
{
    public $conexion;
    protected $db;
    private $server = "localhost";
    private $usu = "root";
    private $clave = "";
    private $base = "bdd";

    private $port = 3306;

    public function Procedimiento_Conectar()
    {
        // Intentar conectar a la base de datos, especificando el puerto
        $this->conexion = mysqli_connect($this->server, $this->usu, $this->clave, $this->base, $this->port);

        // Verificar si la conexión fue exitosa
        if (!$this->conexion) {
            die("Error al conectarse con MySQL: " . mysqli_connect_error());
        }

        // Configurar la conexión para usar el juego de caracteres UTF-8
        if (!mysqli_set_charset($this->conexion, "utf8")) {
            die("Error al configurar el juego de caracteres UTF-8: " . mysqli_error($this->conexion));
        }

        // Seleccionar la base de datos (aunque mysqli_connect ya lo hace)
        $this->db = mysqli_select_db($this->conexion, $this->base);
        if (!$this->db) {
            die("Error al seleccionar la base de datos: " . mysqli_error($this->conexion));
        }

        // Devolver la conexión para su uso posterior
        return $this->conexion;
    }
}
