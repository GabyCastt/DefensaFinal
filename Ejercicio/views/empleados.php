<?php
require_once '../controllers/empleados.controller.php';

$empleadosController = new EmpleadosController();

// Manejar la inserción de empleados
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion']) && $_POST['accion'] === 'insertar') {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $email = $_POST['email'];
    $posicion = $_POST['posicion'];

    if ($empleadosController->insertarEmpleado($nombre, $apellido, $email, $posicion)) {
        $mensaje = "Empleado insertado correctamente.";
    } else {
        $mensaje = "Error al insertar el empleado.";
    }
}

// Manejar la edición de empleados
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion']) && $_POST['accion'] === 'editar') {
    $empleado_id = $_POST['empleado_id'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $email = $_POST['email'];
    $posicion = $_POST['posicion'];

    if ($empleadosController->editarEmpleado($empleado_id, $nombre, $apellido, $email, $posicion)) {
        $mensaje = "Empleado editado correctamente.";
    } else {
        $mensaje = "Error al editar el empleado.";
    }
}

// Manejar la eliminación de un empleado
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['eliminar'])) {
    $empleado_id = $_GET['eliminar'];
    if ($empleadosController->eliminarEmpleado($empleado_id)) {
        $mensaje = "Empleado eliminado correctamente.";
    } else {
        $mensaje = "Error al eliminar el empleado.";
    }
}

// Listar todos los empleados
$empleados = $empleadosController->listarEmpleados();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <?php require_once('./html/head.php') ?>
    <link href="../public/lib/calendar/lib/main.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
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
                    <h1>Gestión de Empleados</h1>
                    <p>Administra a tus empleados de manera eficiente</p>
                </div>
            </div>

            <?php if (isset($mensaje)) : ?>
                <script>
                    Swal.fire({
                        title: '<?php echo $mensaje; ?>',
                        icon: '<?php echo strpos($mensaje, "Error") === false ? "success" : "error"; ?>',
                        confirmButtonText: 'Ok'
                    });
                </script>
            <?php endif; ?>

            <!-- Botón para abrir modal de inserción -->
            <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#nuevoEmpleadoModal">
                Nuevo Empleado
            </button>

            <!-- Modal Nuevo Empleado -->
            <div class="modal fade" id="nuevoEmpleadoModal" tabindex="-1" aria-labelledby="nuevoEmpleadoModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="nuevoEmpleadoModalLabel">Insertar Empleado</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="formInsertarEmpleado" method="POST">
                                <input type="hidden" name="accion" value="insertar">
                                <label>Nombre:</label>
                                <input type="text" name="nombre" class="form-control" required>
                                <label>Apellido:</label>
                                <input type="text" name="apellido" class="form-control" required>
                                <label>Email:</label>
                                <input type="email" name="email" class="form-control" required>
                                <label>Posición:</label>
                                <input type="text" name="posicion" class="form-control">
                                <button type="submit" class="btn btn-success mt-2">Insertar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Lista de Empleados -->
            <h2>Lista de Empleados</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Email</th>
                        <th>Posición</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($empleados as $empleado) : ?>
                        <tr>
                            <td><?php echo $empleado['empleado_id']; ?></td>
                            <td><?php echo $empleado['nombre']; ?></td>
                            <td><?php echo $empleado['apellido']; ?></td>
                            <td><?php echo $empleado['email']; ?></td>
                            <td><?php echo $empleado['posicion']; ?></td>
                            <td>
                                <button type="button" class="btn btn-warning btn-sm editar-empleado" data-bs-toggle="modal" data-bs-target="#editarEmpleadoModal_<?php echo $empleado['empleado_id']; ?>" data-empleado-id="<?php echo $empleado['empleado_id']; ?>">Editar</button>
                                <a href="empleados.php?eliminar=<?php echo $empleado['empleado_id']; ?>" onclick="return confirm('¿Estás seguro de eliminar este empleado?')" class="btn btn-danger btn-sm">Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Modales Editar Empleado -->
            <?php foreach ($empleados as $empleado) : ?>
                <div class="modal fade" id="editarEmpleadoModal_<?php echo $empleado['empleado_id']; ?>" tabindex="-1" aria-labelledby="editarEmpleadoModalLabel_<?php echo $empleado['empleado_id']; ?>" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editarEmpleadoModalLabel_<?php echo $empleado['empleado_id']; ?>">Editar Empleado</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="formEditarEmpleado_<?php echo $empleado['empleado_id']; ?>" method="POST">
                                    <input type="hidden" name="accion" value="editar">
                                    <input type="hidden" name="empleado_id" value="<?php echo $empleado['empleado_id']; ?>">
                                    <label>Nombre:</label>
                                    <input type="text" name="nombre" class="form-control" value="<?php echo $empleado['nombre']; ?>" required>
                                    <label>Apellido:</label>
                                    <input type="text" name="apellido" class="form-control" value="<?php echo $empleado['apellido']; ?>" required>
                                    <label>Email:</label>
                                    <input type="email" name="email" class="form-control" value="<?php echo $empleado['email']; ?>" required>
                                    <label>Posición:</label>
                                    <input type="text" name="posicion" class="form-control" value="<?php echo $empleado['posicion']; ?>">
                                    <button type="submit" class="btn btn-primary mt-2">Guardar Cambios</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Footer Start -->
        <?php require_once('./html/footer.php') ?>
        <!-- Footer End -->
    </div>

    <script>
        $(document).ready(function() {
            // Limpiar datos del formulario al cerrar modal de inserción
            $('#nuevoEmpleadoModal').on('hidden.bs.modal', function() {
                $('#formInsertarEmpleado')[0].reset();
            });

            // Cargar datos del empleado seleccionado en el modal de edición
            $('.editar-empleado').click(function() {
                var empleadoId = $(this).data('empleado-id');
                var empleadoEditar = <?php echo json_encode($empleados); ?>.find(e => e.empleado_id === empleadoId);
                $('#formEditarEmpleado_' + empleadoId + ' input[name="nombre"]').val(empleadoEditar.nombre);
                $('#formEditarEmpleado_' + empleadoId + ' input[name="apellido"]').val(empleadoEditar.apellido);
                $('#formEditarEmpleado_' + empleadoId + ' input[name="email"]').val(empleadoEditar.email);
                $('#formEditarEmpleado_' + empleadoId + ' input[name="posicion"]').val(empleadoEditar.posicion);
            });

            // Limpiar datos del formulario al cerrar modal de edición
            $('div.modal').on('hidden.bs.modal', function() {
                $(this).find('form')[0].reset();
            });
        });
    </script>

</body>

</html>
