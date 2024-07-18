<?php
require_once '../controllers/asignaciones.controller.php';
require_once '../controllers/empleados.controller.php';
require_once '../controllers/proyectos.controller.php';

$asignacionesController = new AsignacionesController();
$proyectosController = new ProyectosController();
$empleadosController = new EmpleadosController();

// Listar proyectos y empleados para los formularios
$proyectos = $proyectosController->listarProyectos();
$empleados = $empleadosController->listarEmpleados();

// Manejar la inserción de una nueva asignación
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion'])) {
    if ($_POST['accion'] === 'insertar') {
        $proyecto_id = $_POST['proyecto_id'];
        $empleado_id = $_POST['empleado_id'];
        $fecha_asignacion = $_POST['fecha_asignacion'];

        if ($asignacionesController->insertarAsignacion($proyecto_id, $empleado_id, $fecha_asignacion)) {
            $mensaje = "Asignación insertada correctamente.";
            echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        var modal = bootstrap.Modal.getInstance(document.getElementById('insertarModal'));
                        modal.hide();
                    });
                  </script>";
        } else {
            $mensaje = "Error al insertar la asignación.";
        }
    }
}

// Manejar la eliminación de una asignación
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['eliminar'])) {
    $asignacion_id = $_GET['eliminar'];

    if ($asignacionesController->eliminarAsignacion($asignacion_id)) {
        $mensaje = "Asignación eliminada correctamente.";
    } else {
        $mensaje = "Error al eliminar la asignación.";
    }
}

// Listar todas las asignaciones
$asignaciones = $asignacionesController->listarAsignaciones();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <?php require_once('./html/head.php') ?>
    <link href="../public/lib/calendar/lib/main.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eiWBKs8sAZAnpD0NkQTTFv0Fqc1Bwqy4kiNHGzsH/Pq6YyqJcSN6qmT2L+7gR63z" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <style>
        .custom-flatpickr {
            display: flex;
            align-items: center;
        }

        .custom-flatpickr input {
            margin-right: 5px;
            flex: 1;
        }

        .welcome-hero {
            background-image: linear-gradient(to bottom, #cce3de, #cce3de);
            background-size: 100% 300px;
            background-position: 0% 100%;
            height: 300px;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #fff;
        }

        .welcome-hero h1 {
            font-size: 36px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .welcome-hero p {
            font-size: 18px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="container-xxl position-relative bg-white d-flex p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Cargando...</span>
            </div>
        </div>
        <!-- Spinner End -->

        <!-- Sidebar Start -->
        <?php require_once('./html/menu.php') ?>
        <!-- Sidebar End -->

        <!-- Content Start -->
        <div class="content">
            <!-- Navbar Start -->
            <?php require_once('./html/header.php') ?>
            <!-- Navbar End -->

            <div class="container-fluid pt-4 px-4">
                <div class="welcome-hero">
                    <h1 class="display-3 fw-bold">Gestión de Asignación a Proyectos</h1>
                    <p class="lead">Administra de manera eficiente</p>
                </div>
                <div class="container mt-5">
                    <!-- Mensaje de éxito o error -->
                    <?php if (isset($mensaje)) : ?>
                        <script>
                            Swal.fire({
                                title: '<?php echo $mensaje; ?>',
                                icon: '<?php echo strpos($mensaje, "Error") === false ? "success" : "error"; ?>',
                                confirmButtonText: 'Ok'
                            });
                        </script>
                    <?php endif; ?>

                    <!-- Botón para abrir el modal -->
                    <button type="button" class="btn mb-3" style="background-color: #4a90e2; color: white;" data-bs-toggle="modal" data-bs-target="#insertarModal">
                        Asignar Proyectos
                    </button>

                    <!-- Lista de Asignaciones -->
                    <h2>Lista de Asignaciones</h2>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Proyecto</th>
                                <th>Empleado</th>
                                <th>Fecha de Asignación</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($asignaciones as $asignacion) : ?>
                                <tr>
                                    <td><?php echo $asignacion['asignacion_id']; ?></td>
                                    <td><?php echo $asignacion['nombre_proyecto']; ?></td>
                                    <td><?php echo $asignacion['nombre_empleado']; ?></td>
                                    <td><?php echo $asignacion['fecha_asignacion']; ?></td>
                                    <td>
                                        <!-- Botón para eliminar -->
                                        <a href="asignaciones.php?eliminar=<?php echo $asignacion['asignacion_id']; ?>" class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar esta asignación?')">Eliminar</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Footer Start -->
            <?php require_once('./html/footer.php') ?>
            <!-- Footer End -->
        </div>
        <!-- Content End -->

        <!-- Back to Top -->
        <a href='#' class='btn btn-lg btn-primary btn-lg-square back-to-top'><i class='bi bi-arrow-up'></i></a>
    </div>

    <!-- Modal para insertar asignación -->
    <div class="modal fade" id="insertarModal" tabindex="-1" aria-labelledby="insertarModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="insertarModalLabel">Insertar Nueva Asignación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="insertarForm" method="POST">
                        <input type="hidden" name="accion" value="insertar">
                        <div class="mb-3">
                            <label for="proyecto_id" class="form-label">Proyecto:</label>
                            <select id="proyecto_id" name="proyecto_id" class="form-select" required>
                                <option value="">Seleccione un proyecto</option>
                                <?php foreach ($proyectos as $proyecto) : ?>
                                    <option value="<?php echo $proyecto['proyecto_id']; ?>"><?php echo $proyecto['nombre']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="empleado_id" class="form-label">Empleado:</label>
                            <select id="empleado_id" name="empleado_id" class="form-select" required>
                                <option value="">Seleccione un empleado</option>
                                <?php foreach ($empleados as $empleado) : ?>
                                    <option value="<?php echo $empleado['empleado_id']; ?>"><?php echo $empleado['nombre'] . ' ' . $empleado['apellido']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="fecha_asignacion" class="form-label">Fecha de Asignación:</label>
                            <div class="custom-flatpickr">
                                <input type="text" id="fecha_asignacion" name="fecha_asignacion" class="form-control" required>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" form="insertarForm" class="btn btn-success">Insertar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript Libraries -->
    <?php require_once('./html/scripts.php') ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            flatpickr('#fecha_asignacion', {
                dateFormat: 'Y-m-d',
                minDate: 'today'
            });
        });
    </script>
</body>

</html>