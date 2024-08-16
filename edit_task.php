<?php
// Inicia la sesión para manejar datos persistentes durante la navegación del usuario.
session_start();

// Incluye el archivo de cabecera que generalmente contiene la estructura común de la página.
include("includes/header.php");

// Verifica si se ha pasado un ID a través de la URL para identificar la tarea a editar.
if (isset($_GET['id'])) {
    // Convierte el ID a un entero para evitar posibles vulnerabilidades de inyección.
    $id = intval($_GET['id']);

    // Llamada a la API para obtener los detalles de la tarea según su ID.
    $url = 'http://localhost/php_crud/api.php?id=' . $id;
    // Inicializa la sesión cURL con la URL de la API.
    $ch = curl_init($url);
    // Configura cURL para que la respuesta sea devuelta como una cadena.
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    // Configura cURL para realizar una solicitud HTTP GET.
    curl_setopt($ch, CURLOPT_HTTPGET, true);
    // Ejecuta la solicitud y almacena la respuesta.
    $response = curl_exec($ch);
    // Cierra la sesión cURL.
    curl_close($ch);

    // Decodifica la respuesta JSON de la API en un array asociativo.
    $task = json_decode($response, true);

    // Verifica si la tarea fue encontrada, de lo contrario, termina la ejecución.
    if (!$task) {
        die("Task not found");
    }

    // Almacena el título y la descripción de la tarea en variables para su uso posterior.
    $title = $task['title'];
    $description = $task['description'];
} else {
    // Si no se proporcionó un ID en la URL, termina la ejecución con un mensaje de error.
    die("ID not provided");
}

// Verifica si el formulario de actualización ha sido enviado.
if (isset($_POST['update'])) {
    // Obtiene los valores del formulario.
    $title = $_POST['title'];
    $description = $_POST['description'];

    // Llamada a la API para actualizar la tarea con los nuevos valores.
    $url = 'http://localhost/php_crud/api.php?id=' . $id;
    $data = [
        'title' => $title,
        'description' => $description
    ];
    // Inicializa la sesión cURL con la URL de la API.
    $ch = curl_init($url);
    // Configura cURL para que la respuesta sea devuelta como una cadena.
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
    // Configura cURL para realizar una solicitud HTTP PUT (actualización).
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT"); 
    // Configura cURL para enviar los datos en formato JSON.
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data)); 
    // Define el tipo de contenido como JSON.
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']); 
    // Ejecuta la solicitud y almacena la respuesta.
    $response = curl_exec($ch); 
    // Cierra la sesión cURL.
    curl_close($ch); 
    // Decodifica la respuesta JSON de la API en un array asociativo.
    $result = json_decode($response, true);

    // Si la respuesta contiene un mensaje de éxito, se guarda en la sesión y se redirige al usuario a la página principal.
    if (isset($result['message'])) {
        $_SESSION['message'] = 'Task Updated Successfully';
        // Define el tipo de mensaje como "warning" para mostrarlo en amarillo.
        $_SESSION['message_type'] = 'warning'; 
        header("Location: index.php");
        exit;
    } else {
        // Si hubo un error al actualizar la tarea, termina la ejecución con un mensaje de error.
        die("Error updating task");
    }
}

// Inicia el almacenamiento de la salida del script en un buffer.
ob_start();

// Incluye la vista HTML donde se muestra el formulario de edición de la tarea.
include("templates/edit_task.html");

// Obtiene el contenido almacenado en el buffer y lo asigna a una variable.
$html = ob_get_clean();

// Reemplaza los placeholders {{id}}, {{title}}, y {{description}} en el HTML con los valores dinámicos.
$html = str_replace("{{id}}", htmlspecialchars($id), $html);
$html = str_replace("{{title}}", htmlspecialchars($title), $html);
$html = str_replace("{{description}}", htmlspecialchars($description), $html);

// Imprime el HTML resultante en la página.
echo $html;

// Incluye el archivo de pie de página que generalmente contiene la estructura común de la parte inferior de la página.
include("includes/footer.php");
