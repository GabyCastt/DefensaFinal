<?php
require_once '../config/conexion.php';
require_once '../models/empleados.model.php';

class EmpleadosController
{
    private $empleadosModel;

    public function __construct()
    {
        $this->empleadosModel = new Empleados();
    }

    public function insertarEmpleado($nombre, $apellido, $email, $posicion)
    {
        return $this->empleadosModel->insertarEmpleado($nombre, $apellido, $email, $posicion);
    }

    public function editarEmpleado($empleado_id, $nombre, $apellido, $email, $posicion)
    {
        return $this->empleadosModel->editarEmpleado($empleado_id, $nombre, $apellido, $email, $posicion);
    }

    public function eliminarEmpleado($empleado_id)
    {
        return $this->empleadosModel->eliminarEmpleado($empleado_id);
    }

    public function listarEmpleados()
    {
        return $this->empleadosModel->listarEmpleados();
    }
    public function listarEmpleadosPorProyecto($proyecto_id)
    {
        return $this->empleadosModel->listarEmpleadosPorProyecto($proyecto_id);
    }
}
?>
