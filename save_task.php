<?php
session_start(); // Asegúrate de que la sesión esté iniciada

// Verifica si los datos POST están presentes
if (isset($_POST['title']) && isset($_POST['description'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];

    // Verifica si la conexión a la base de datos está correctamente configurada
    include_once("controlador/task_service.php");
    $taskService = new TaskService();

    // Llama al método para guardar la tarea
    $result = $taskService->saveTask($title, $description);

    if ($result) {
        echo json_encode(["message" => "Task Saved Successfully"]);
    } else {
        echo json_encode(["error" => "Failed to save task"]);
    }
} else {
    echo json_encode(["error" => "Invalid input"]);
}
?>
