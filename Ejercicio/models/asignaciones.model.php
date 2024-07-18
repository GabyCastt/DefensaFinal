<?php

class Asignaciones
{
    private $conexion;

    public function __construct()
    {
        $this->conexion = (new Clase_Conectar())->Procedimiento_Conectar();
    }

    public function insertarAsignacion($proyecto_id, $empleado_id, $fecha_asignacion)
    {
        $sql = "INSERT INTO Asignaciones (proyecto_id, empleado_id, fecha_asignacion) VALUES (?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("iis", $proyecto_id, $empleado_id, $fecha_asignacion);
        return $stmt->execute();
    }

    public function editarAsignacion($asignacion_id, $proyecto_id, $empleado_id, $fecha_asignacion)
    {
        $sql = "UPDATE Asignaciones SET proyecto_id = ?, empleado_id = ?, fecha_asignacion = ? WHERE asignacion_id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("iisi", $proyecto_id, $empleado_id, $fecha_asignacion, $asignacion_id);
        return $stmt->execute();
    }

    public function eliminarAsignacion($asignacion_id)
    {
        $sql = "DELETE FROM Asignaciones WHERE asignacion_id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $asignacion_id);
        return $stmt->execute();
    }

    public function listarAsignaciones()
    {
        $sql = "SELECT * FROM Asignaciones";
        $result = $this->conexion->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>
