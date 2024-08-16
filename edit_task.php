<?php
session_start(); // Asegúrate de que la sesión esté iniciada
include("includes/header.php");

// Obtener el ID de la tarea a editar
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // Llamada a la API para obtener los detalles de la tarea
    $url = 'http://localhost/php_crud/api.php?id=' . $id;
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPGET, true);
    $response = curl_exec($ch);
    curl_close($ch);

    $task = json_decode($response, true);
    if (!$task) {
        die("Task not found");
    }
    $title = $task['title'];
    $description = $task['description'];
} else {
    die("ID not provided");
}

// Actualizar la tarea
if (isset($_POST['update'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];

    // Llamada a la API para actualizar la tarea
    $url = 'http://localhost/php_crud/api.php?id=' . $id;
    $data = [
        'title' => $title,
        'description' => $description
    ];
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    $response = curl_exec($ch);
    curl_close($ch);

    $result = json_decode($response, true);
    if (isset($result['message'])) {
        $_SESSION['message'] = 'Task Updated Successfully';
        $_SESSION['message_type'] = 'warning';
        header("Location: index.php");
        exit;
    } else {
        die("Error updating task");
    }
}

// Comenzar el buffer de salida
ob_start();

// Incluir la vista HTML
include("templates/edit_task.html");

// Obtener el contenido del buffer
$html = ob_get_clean();

// Reemplazar los placeholders {{title}}, {{description}}, y {{id}} en el HTML con el contenido dinámico
$html = str_replace("{{id}}", htmlspecialchars($id), $html);
$html = str_replace("{{title}}", htmlspecialchars($title), $html);
$html = str_replace("{{description}}", htmlspecialchars($description), $html);

// Imprimir el HTML resultante
echo $html;

include("includes/footer.php");
?>
