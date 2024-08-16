$(document).ready(function() {
    console.log("Document is ready"); // Verifica si el documento está listo

    // Capturar el evento de clic en el botón Save Task
    $('#save_task').on('click', function(event) {
        event.preventDefault(); // Prevenir el comportamiento por defecto del botón

        console.log("Save Task button clicked"); // Verifica si el botón fue clickeado

        // Obtener los datos del formulario
        var title = $('#title').val();
        var description = $('#description').val();

        // Validar que los campos no estén vacíos
        if (title === "" || description === "") {
            alert("Please fill in all fields.");
            return;
        }

        // Realizar una solicitud AJAX para guardar la nueva tarea
        $.ajax({
            url: 'save_task.php', // Ruta al archivo PHP que maneja la lógica del backend
            method: 'POST',
            data: {
                title: title,
                description: description
            },
            success: function(response) {
                console.log("AJAX request successful"); // Verifica si la solicitud fue exitosa
                alert("Task Saved Successfully!");
                // Redirigir o actualizar la página después de guardar la tarea
                window.location.href = 'index.php'; // Asegúrate de que la redirección sea a la página correcta
            },
            error: function(xhr, status, error) {
                console.log("AJAX request error: " + error); // Verifica si ocurrió un error
                alert("Error saving task: " + error);
            }
        });
    });
});
