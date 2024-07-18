<?php
require_once '../models/proyectos.model.php';

class ProyectosController {
    private $model;

    public function __construct($conexion) {
        $this->model = new ProyectosModel($conexion);
    }

    public function crearProyecto() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['crear'])) {
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            $fecha_inicio = $_POST['fecha_inicio'];
            $fecha_fin = $_POST['fecha_fin'];
            
            $resultado = $this->model->crearProyecto($nombre, $descripcion, $fecha_inicio, $fecha_fin);
            
            if ($resultado) {
                echo json_encode(['status' => 'success', 'message' => 'Proyecto creado exitosamente']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error al crear el proyecto']);
            }
            exit;
        }
    }

    public function obtenerProyecto() {
        if (isset($_GET['proyecto_id'])) {
            return $this->model->obtenerProyecto($_GET['proyecto_id']);
        }
        return null;
    }

    public function editarProyecto() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editar'])) {
            $proyecto_id = $_POST['proyecto_id'];
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            $fecha_inicio = $_POST['fecha_inicio'];
            $fecha_fin = $_POST['fecha_fin'];
            
            $resultado = $this->model->editarProyecto($proyecto_id, $nombre, $descripcion, $fecha_inicio, $fecha_fin);
            
            if ($resultado) {
                echo json_encode(['status' => 'success', 'message' => 'Proyecto editado exitosamente']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error al editar el proyecto']);
            }
            exit;
        }
    }

    public function eliminarProyecto() {
        if (isset($_GET['eliminar']) && isset($_GET['proyecto_id'])) {
            $proyecto_id = $_GET['proyecto_id'];
            if ($this->model->eliminarProyecto($proyecto_id)) {
                header('Location: proyectos.php');
                exit;
            } else {
                echo "Error al eliminar el proyecto.";
            }
        }
    }

    public function listarProyectos() {
        try {
            return $this->model->listarProyectos();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
    }
}

?>

