$(document).ready(function() {
    // Manejar el envío del formulario para crear o editar un proyecto
    $('form').on('submit', function(e) {
        e.preventDefault();

        var formData = $(this).serialize();
        var actionUrl = $(this).attr('action');

        $.ajax({
            url: actionUrl,
            type: 'POST',
            data: formData,
            success: function(response) {
                // Actualizar la lista de proyectos o mostrar un mensaje de éxito
                alert('Proyecto guardado exitosamente.');
                location.reload(); // Recargar la página para actualizar la lista de proyectos
            },
            error: function() {
                alert('Ocurrió un error al guardar el proyecto.');
            }
        });
    });

    // Manejar la eliminación de proyectos
    $('.btn-danger').on('click', function(e) {
        e.preventDefault();

        if (confirm('¿Está seguro de eliminar este proyecto?')) {
            var deleteUrl = $(this).attr('href');

            $.ajax({
                url: deleteUrl,
                type: 'GET',
                success: function(response) {
                    // Actualizar la lista de proyectos o mostrar un mensaje de éxito
                    alert('Proyecto eliminado exitosamente.');
                    location.reload(); // Recargar la página para actualizar la lista de proyectos
                },
                error: function() {
                    alert('Ocurrió un error al eliminar el proyecto.');
                }
            });
        }
    });
});
