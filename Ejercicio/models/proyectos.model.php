<?php
class ProyectosModel {
    private $conn;

    public function __construct($conexion) {
        $this->conn = $conexion;
    }

    public function crearProyecto($nombre, $descripcion, $fecha_inicio, $fecha_fin) {
        $sql = "INSERT INTO Proyectos (nombre, descripcion, fecha_inicio, fecha_fin) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($this->conn, $sql);
        if (!$stmt) {
            return "Error en la preparación de la consulta: " . mysqli_error($this->conn);
        }
        mysqli_stmt_bind_param($stmt, "ssss", $nombre, $descripcion, $fecha_inicio, $fecha_fin);
        $resultado = mysqli_stmt_execute($stmt);
        if (!$resultado) {
            return "Error al ejecutar la consulta: " . mysqli_stmt_error($stmt);
        }
        mysqli_stmt_close($stmt);
        return true;
    }

    public function obtenerProyecto($proyecto_id) {
        $sql = "SELECT * FROM Proyectos WHERE proyecto_id = ?";
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $proyecto_id);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);
        $proyecto = mysqli_fetch_assoc($resultado);
        mysqli_stmt_close($stmt);
        return $proyecto;
    }

    public function editarProyecto($proyecto_id, $nombre, $descripcion, $fecha_inicio, $fecha_fin) {
        $sql = "UPDATE Proyectos SET nombre = ?, descripcion = ?, fecha_inicio = ?, fecha_fin = ? WHERE proyecto_id = ?";
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssssi", $nombre, $descripcion, $fecha_inicio, $fecha_fin, $proyecto_id);
        $resultado = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        return $resultado;
    }

    public function eliminarProyecto($proyecto_id) {
        $sql = "DELETE FROM Proyectos WHERE proyecto_id = ?";
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $proyecto_id);
        $resultado = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        return $resultado;
    }

    public function listarProyectos() {
        $sql = "SELECT * FROM Proyectos ORDER BY fecha_inicio DESC";
        $result = mysqli_query($this->conn, $sql);
        if (!$result) {
            throw new Exception("Error en la consulta: " . mysqli_error($this->conn));
        }
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
}
?>
