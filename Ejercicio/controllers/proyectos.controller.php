<?php
require_once '../config/conexion.php';
require_once '../models/proyectos.model.php';

class ProyectosController
{
    private $proyectosModel;

    public function __construct()
    {
        $this->proyectosModel = new Proyectos();
    }

    public function insertarProyecto($nombre, $descripcion, $fecha_inicio, $fecha_fin)
    {
        return $this->proyectosModel->insertarProyecto($nombre, $descripcion, $fecha_inicio, $fecha_fin);
    }

    public function editarProyecto($proyecto_id, $nombre, $descripcion, $fecha_inicio, $fecha_fin)
    {
        return $this->proyectosModel->editarProyecto($proyecto_id, $nombre, $descripcion, $fecha_inicio, $fecha_fin);
    }
    public function eliminarProyecto($proyecto_id)
    {
        return $this->proyectosModel->eliminarProyecto($proyecto_id);
    }

    public function listarProyectos()
    {
        return $this->proyectosModel->listarProyectos();
    }
}

