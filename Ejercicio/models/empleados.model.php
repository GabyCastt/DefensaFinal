<?php

class Empleados
{
    private $conexion;

    public function __construct()
    {
        $this->conexion = (new Clase_Conectar())->Procedimiento_Conectar();
    }

    public function insertarEmpleado($nombre, $apellido, $email, $posicion)
    {
        $sql = "INSERT INTO Empleados (nombre, apellido, email, posicion) VALUES (?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("ssss", $nombre, $apellido, $email, $posicion);
        return $stmt->execute();
    }

    public function editarEmpleado($empleado_id, $nombre, $apellido, $email, $posicion)
    {
        $sql = "UPDATE Empleados SET nombre = ?, apellido = ?, email = ?, posicion = ? WHERE empleado_id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("ssssi", $nombre, $apellido, $email, $posicion, $empleado_id);
        return $stmt->execute();
    }

    public function eliminarEmpleado($empleado_id)
    {
        $sql = "DELETE FROM Empleados WHERE empleado_id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $empleado_id);
        return $stmt->execute();
    }

    public function listarEmpleados()
    {
        $sql = "SELECT * FROM Empleados";
        $result = $this->conexion->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    public function listarEmpleadosPorProyecto($proyecto_id)
    {
        $sql = "SELECT e.empleado_id, e.nombre, e.apellido, e.email, e.posicion 
            FROM Empleados e
            INNER JOIN Asignaciones a ON e.empleado_id = a.empleado_id
            WHERE a.proyecto_id = ?";

        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $proyecto_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $empleados = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $empleados;
    }
}
