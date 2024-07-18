<?php
require_once '../controllers/proyectos.controller.php';

$proyectosController = new ProyectosController();

// Manejar la inserción de un nuevo proyecto
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion'])) {
    if ($_POST['accion'] === 'insertar') {
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $fecha_inicio = $_POST['fecha_inicio'];
        $fecha_fin = $_POST['fecha_fin'];

        if ($proyectosController->insertarProyecto($nombre, $descripcion, $fecha_inicio, $fecha_fin)) {
            $mensaje = "Proyecto insertado correctamente.";
        } else {
            $mensaje = "Error al insertar el proyecto.";
        }
    } elseif ($_POST['accion'] === 'editar') {
        $proyecto_id = $_POST['proyecto_id'];
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $fecha_inicio = $_POST['fecha_inicio'];
        $fecha_fin = $_POST['fecha_fin'];

        if ($proyectosController->editarProyecto($proyecto_id, $nombre, $descripcion, $fecha_inicio, $fecha_fin)) {
            $mensaje = "Proyecto editado correctamente.";
        } else {
            $mensaje = "Error al editar el proyecto.";
        }
    }
}

// Manejar la eliminación de un proyecto
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['eliminar'])) {
    $proyecto_id = $_GET['eliminar'];

    if ($proyectosController->eliminarProyecto($proyecto_id)) {
        $mensaje = "Proyecto eliminado correctamente.";
    } else {
        $mensaje = "Error al eliminar el proyecto.";
    }
}

// Listar todos los proyectos
$proyectos = $proyectosController->listarProyectos();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <?php require_once('./html/head.php') ?>
    <link href="../public/lib/calendar/lib/main.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
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

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }

        form {
            margin-bottom: 20px;
        }

        input,
        textarea {
            width: 100%;
            padding: 8px;
            margin: 4px 0;
        }

        button {
            padding: 10px 20px;
        }
    </style>
</head>

<body>
    <!-- Spinner End -->

    <!-- Sidebar Start -->
    <?php require_once('./html/menu.php') ?>
    <!-- Sidebar End -->

    <!-- Content Start -->
    <div class="content">
        <!-- Navbar Start -->
        <?php require_once('./html/header.php') ?>
        <!-- Navbar End -->

        <div class="container mt-5">
            <div class="welcome-hero">
                <div>
                    <h1>Gestión de Asignación a Proyectos</h1>
                    <p>Administra de manera eficiente</p>
                </div>
            </div>

            <div class="container mt-5">
                <?php if (isset($mensaje)) : ?>
                    <p><?php echo $mensaje; ?></p>
                <?php endif; ?>

                <form method="POST">
                    <h2>Insertar Proyecto</h2>
                    <input type="hidden" name="accion" value="insertar">
                    <label>Nombre:</label>
                    <input type="text" name="nombre" required>
                    <br>
                    <label>Descripción:</label>
                    <textarea name="descripcion" required></textarea>
                    <br>
                    <label>Fecha de Inicio:</label>
                    <input type="date" name="fecha_inicio" required>
                    <br>
                    <label>Fecha de Fin:</label>
                    <input type="date" name="fecha_fin">
                    <br>
                    <button type="submit">Insertar</button>
                </form>

                <h2>Lista de Proyectos</h2>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Fecha de Inicio</th>
                            <th>Fecha de Fin</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($proyectos as $proyecto) : ?>
                            <tr>
                                <td><?php echo $proyecto['proyecto_id']; ?></td>
                                <td><?php echo $proyecto['nombre']; ?></td>
                                <td><?php echo $proyecto['descripcion']; ?></td>
                                <td><?php echo $proyecto['fecha_inicio']; ?></td>
                                <td><?php echo $proyecto['fecha_fin']; ?></td>
                                <td>
                                    <a href="#" class="btn btn-primary editar-proyecto" data-bs-toggle="modal" data-bs-target="#editarProyectoModal" data-proyecto-id="<?php echo $proyecto['proyecto_id']; ?>">Editar</a>
                                    <a href="proyectos.php?eliminar=<?php echo $proyecto['proyecto_id']; ?>" onclick="return confirm('¿Estás seguro de eliminar este proyecto?')" class="btn btn-danger">Eliminar</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <!-- Modal Editar Proyecto -->
                <div class="modal fade" id="editarProyectoModal" tabindex="-1" aria-labelledby="editarProyectoModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form id="formEditarProyecto" method="POST">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editarProyectoModalLabel">Editar Proyecto</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="accion" value="editar">
                                    <input type="hidden" id="proyecto_id_editar" name="proyecto_id">
                                    <label>Nombre:</label>
                                    <input type="text" id="nombre_editar" name="nombre" required>
                                    <br>
                                    <label>Descripción:</label>
                                    <textarea id="descripcion_editar" name="descripcion" required></textarea>
                                    <br>
                                    <label>Fecha de Inicio:</label>
                                    <input type="date" id="fecha_inicio_editar" name="fecha_inicio" required>
                                    <br>
                                    <label>Fecha de Fin:</label>
                                    <input type="date" id="fecha_fin_editar" name="fecha_fin">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Fin Modal Editar Proyecto -->

            </div>

            <!-- Footer Start -->
            <?php require_once('./html/footer.php') ?>
            <!-- Footer End -->
        </div>
        <!-- Content End -->

        <script>
            $(document).ready(function () {
                // Obtener datos del proyecto para editar
                $('.editar-proyecto').click(function () {
                    var proyectoId = $(this).data('proyecto-id');
                    var proyecto = <?php echo json_encode($proyectos); ?>;
                    var proyectoEditar = proyecto.find(p => p.proyecto_id == proyectoId);
                    $('#proyecto_id_editar').val(proyectoEditar.proyecto_id);
                    $('#nombre_editar').val(proyectoEditar.nombre);
                    $('#descripcion_editar').val(proyectoEditar.descripcion);
                    $('#fecha_inicio_editar').val(proyectoEditar.fecha_inicio);
                    $('#fecha_fin_editar').val(proyectoEditar.fecha_fin);
                });

                // Limpiar datos del formulario al cerrar modal
                $('#editarProyectoModal').on('hidden.bs.modal', function () {
                    $('#formEditarProyecto')[0].reset();
                });
            });
        </script>

</body>

</html>
