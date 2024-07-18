<?php
require_once '../config/conexion.php';
require_once '../models/asignaciones.model.php';

class AsignacionesController
{
    private $asignacionesModel;

    public function __construct()
    {
        $this->asignacionesModel = new Asignaciones();
    }

    public function insertarAsignacion($proyecto_id, $empleado_id, $fecha_asignacion)
    {
        return $this->asignacionesModel->insertarAsignacion($proyecto_id, $empleado_id, $fecha_asignacion);
    }

    public function editarAsignacion($asignacion_id, $proyecto_id, $empleado_id, $fecha_asignacion)
    {
        return $this->asignacionesModel->editarAsignacion($asignacion_id, $proyecto_id, $empleado_id, $fecha_asignacion);
    }

    public function eliminarAsignacion($asignacion_id)
    {
        return $this->asignacionesModel->eliminarAsignacion($asignacion_id);
    }

    public function listarAsignaciones()
    {
        return $this->asignacionesModel->listarAsignaciones();
    }
}
?>
