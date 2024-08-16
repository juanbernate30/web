<?php
// Verifica si se ha recibido un ID a través de la URL (método GET).
if (isset($_GET['id'])) {
    // Se almacena el ID recibido en una variable.
    $id = $_GET['id'];
    
    // Se construye la URL para hacer la solicitud DELETE a la API.
    $url = 'http://localhost/php_crud/api.php?id=' . $id;

    // Inicializa una sesión cURL para la URL especificada.
    $ch = curl_init($url);
    
    // Configura cURL para que retorne el resultado como una cadena.
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    // Configura cURL para enviar una solicitud HTTP DELETE.
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");

    // Ejecuta la solicitud cURL y almacena la respuesta.
    $response = curl_exec($ch);
    
    // Cierra la sesión cURL.
    curl_close($ch);

    // Establece un mensaje en la sesión indicando que la tarea se eliminó correctamente.
    $_SESSION['message'] = 'Task Deleted Successfully';
    
    // Define el tipo de mensaje (en este caso, "danger" para mostrarlo en rojo).
    $_SESSION['message_type'] = 'danger';

    // Redirige al usuario de vuelta a la página principal (index.php).
    header("Location: index.php");
}
?>
