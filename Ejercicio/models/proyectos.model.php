<?php

class Proyectos
{
    private $conexion;

    public function __construct()
    {
        $this->conexion = (new Clase_Conectar())->Procedimiento_Conectar();
    }

    public function insertarProyecto($nombre, $descripcion, $fecha_inicio, $fecha_fin)
    {
        $sql = "INSERT INTO Proyectos (nombre, descripcion, fecha_inicio, fecha_fin) VALUES (?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("ssss", $nombre, $descripcion, $fecha_inicio, $fecha_fin);
        return $stmt->execute();
    }

    public function editarProyecto($proyecto_id, $nombre, $descripcion, $fecha_inicio, $fecha_fin)
    {
        $sql = "UPDATE Proyectos SET nombre = ?, descripcion = ?, fecha_inicio = ?, fecha_fin = ? WHERE proyecto_id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("ssssi", $nombre, $descripcion, $fecha_inicio, $fecha_fin, $proyecto_id);
        return $stmt->execute();
    }

    public function eliminarProyecto($proyecto_id)
    {
        $sql = "DELETE FROM Proyectos WHERE proyecto_id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $proyecto_id);
        return $stmt->execute();
    }

    public function listarProyectos()
    {
        $sql = "SELECT * FROM Proyectos";
        $result = $this->conexion->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
