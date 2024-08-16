<?php
include("controlador/task_service.php"); // Asegúrate de que la ruta sea correcta

header('Content-Type: application/json');

$taskService = new TaskService();

// Obtener el método HTTP (GET, POST, PUT, DELETE)
$method = $_SERVER['REQUEST_METHOD'];

// Obtener los datos de la URL
$input = json_decode(file_get_contents('php://input'), true);
$id = isset($_GET['id']) ? $_GET['id'] : null;

switch ($method) {
    case 'GET':
        if ($id) {
            // Obtener una tarea por ID
            $task = $taskService->getTaskById($id);
            echo json_encode($task);
        } else {
            // Obtener todas las tareas
            $tasks = $taskService->getTasks();
            echo json_encode($tasks);
        }
        break;
    
    case 'POST':
        // Crear una nueva tarea
        if (isset($input['title']) && isset($input['description'])) {
            $taskService->saveTask($input['title'], $input['description']);
            echo json_encode(["message" => "Task Created Successfully"]);
        } else {
            echo json_encode(["error" => "Invalid Input"]);
        }
        break;

    case 'PUT':
        // Actualizar una tarea existente
        if ($id && isset($input['title']) && isset($input['description'])) {
            $taskService->updateTask($id, $input['title'], $input['description']);
            echo json_encode(["message" => "Task Updated Successfully"]);
        } else {
            echo json_encode(["error" => "Invalid Input"]);
        }
        break;

    case 'DELETE':
        // Eliminar una tarea por ID
        if ($id) {
            $taskService->deleteTask($id);
            echo json_encode(["message" => "Task Deleted Successfully"]);
        } else {
            echo json_encode(["error" => "Invalid ID"]);
        }
        break;

    default:
        echo json_encode(["error" => "Method Not Supported"]);
        break;
}
?>
