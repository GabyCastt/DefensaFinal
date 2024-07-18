<?php
require_once '../controllers/proyectos.controller.php';
require_once '../config/conexion.php';

$conexionObj = new Clase_Conectar();
$conexion = $conexionObj->Procedimiento_Conectar();

$controller = new ProyectosController($conexion);

// Manejar las acciones del controlador
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['crear'])) {
        $controller->crearProyecto();
    } elseif (isset($_POST['editar'])) {
        $controller->editarProyecto();
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['eliminar']) && isset($_GET['proyecto_id'])) {
        $controller->eliminarProyecto();
    }
}

$proyectos = $controller->listarProyectos();
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
        /* ... (estilos sin cambios) ... */
    </style>
</head>

<body>
    <!-- Sidebar Start -->
    <?php require_once('./html/menu.php') ?>
    <!-- Sidebar End -->

    <!-- Content Start -->
    <div class="content">
        <!-- Navbar Start -->
        <?php require_once('./html/header.php') ?>
        <!-- Navbar End -->

        <!-- Hero Section -->
        <div class="welcome-hero">
            <div>
                <h1>Gestión de Proyectos</h1>
                <p>Administra tus proyectos de manera eficiente</p>
            </div>
        </div>

        <!-- Formulario de creación/edición de proyectos -->
        <div class="container mt-5">
            <h2><?php echo isset($_GET['proyecto_id']) ? 'Editar Proyecto' : 'Crear Proyecto'; ?></h2>
            <form id="proyectoForm" action="" method="POST">
                <input type="hidden" name="proyecto_id" id="proyecto_id" value="<?php echo isset($_GET['proyecto_id']) ? $_GET['proyecto_id'] : ''; ?>">
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre del Proyecto</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                </div>
                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea class="form-control" id="descripcion" name="descripcion" required></textarea>
                </div>
                <div class="mb-3 custom-flatpickr">
                    <label for="fecha_inicio" class="form-label">Fecha de Inicio</label>
                    <input type="text" class="form-control" id="fecha_inicio" name="fecha_inicio" required>
                </div>
                <div class="mb-3 custom-flatpickr">
                    <label for="fecha_fin" class="form-label">Fecha de Fin</label>
                    <input type="text" class="form-control" id="fecha_fin" name="fecha_fin">
                </div>
                <?php if (isset($_GET['proyecto_id'])): ?>
                    <button type="submit" name="editar" class="btn btn-primary">Editar Proyecto</button>
                <?php else: ?>
                    <button type="submit" name="crear" class="btn btn-success">Crear Proyecto</button>
                <?php endif; ?>
            </form>
        </div>

        <!-- Lista de proyectos -->
        <div class="container mt-5">
            <h2>Lista de Proyectos</h2>
            <table class="table">
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
                    <?php foreach ($proyectos as $proyecto): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($proyecto['proyecto_id']); ?></td>
                            <td><?php echo htmlspecialchars($proyecto['nombre']); ?></td>
                            <td><?php echo htmlspecialchars($proyecto['descripcion']); ?></td>
                            <td><?php echo htmlspecialchars($proyecto['fecha_inicio']); ?></td>
                            <td><?php echo htmlspecialchars($proyecto['fecha_fin']); ?></td>
                            <td>
                                <a href="?proyecto_id=<?php echo $proyecto['proyecto_id']; ?>" class="btn btn-sm btn-primary">Editar</a>
                                <a href="?eliminar&proyecto_id=<?php echo $proyecto['proyecto_id']; ?>" class="btn btn-sm btn-danger btn-eliminar">Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Footer Start -->
        <?php require_once('./html/footer.php') ?>
        <!-- Footer End -->
    </div>
    <!-- Content End -->

    <script>
        $(document).ready(function() {
            // Inicializar Flatpickr
            flatpickr('#fecha_inicio', {
                dateFormat: "Y-m-d"
            });
            flatpickr('#fecha_fin', {
                dateFormat: "Y-m-d"
            });

            // Cargar datos del proyecto si estamos en modo edición
            <?php if (isset($_GET['proyecto_id'])): ?>
            $.ajax({
                url: '../controllers/proyectos.controller.php',
                type: 'GET',
                data: { proyecto_id: <?php echo $_GET['proyecto_id']; ?> },
                dataType: 'json',
                success: function(proyecto) {
                    $('#proyecto_id').val(proyecto.proyecto_id);
                    $('#nombre').val(proyecto.nombre);
                    $('#descripcion').val(proyecto.descripcion);
                    $('#fecha_inicio').val(proyecto.fecha_inicio);
                    $('#fecha_fin').val(proyecto.fecha_fin);
                },
                error: function() {
                    Swal.fire('Error', 'Error al cargar los datos del proyecto.', 'error');
                }
            });
            <?php endif; ?>

            // Cargar proyecto si se proporciona un ID
            <?php if (isset($_GET['proyecto_id'])): ?>
            cargarProyecto(<?php echo $_GET['proyecto_id']; ?>);
            <?php endif; ?>

            // Manejar el envío del formulario para crear o editar un proyecto
            $('#proyectoForm').on('submit', function(e) {
                e.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    url: '../controllers/proyectos.controller.php',
                    type: 'POST', 
                    data: formData,
                    dataType: 'json', 
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire('Éxito', response.message, 'success').then((result) => {
                                if (result.isConfirmed) {
                                    location.reload();
                                }
                            });
                        } else {
                            Swal.fire('Error', response.message, 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Error', 'Ocurrió un error al procesar la solicitud.', 'error');
                    }
                });
            });


            // Manejar la eliminación de proyectos
            $('.btn-eliminar').on('click', function(e) {
                e.preventDefault();
                var deleteUrl = $(this).attr('href');
                Swal.fire({
                    title: '¿Está seguro?',
                    text: "Esta acción no se puede deshacer",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: deleteUrl,
                            type: 'GET',
                            success: function(response) {
                                Swal.fire('Eliminado', 'El proyecto ha sido eliminado.', 'success').then((result) => {
                                    if (result.isConfirmed) {
                                        location.reload();
                                    }
                                });
                            },
                            error: function() {
                                Swal.fire('Error', 'Ocurrió un error al eliminar el proyecto.', 'error');
                            }
                        });
                    }
                });
            });
        });
    </script>
</body>

</html>