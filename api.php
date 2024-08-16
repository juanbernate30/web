<?php
// Se incluye el archivo que contiene la clase TaskService.
include("controlador/task_service.php"); // Asegúrate de que la ruta sea correcta

// Se establece el tipo de contenido de la respuesta como JSON.
header('Content-Type: application/json');

// Se crea una instancia del servicio de tareas.
$taskService = new TaskService();

// Se obtiene el método HTTP utilizado en la solicitud (GET, POST, PUT, DELETE).
$method = $_SERVER['REQUEST_METHOD'];

// Se obtienen los datos del cuerpo de la solicitud en formato JSON.
$input = json_decode(file_get_contents('php://input'), true);

// Se obtiene el ID de la tarea desde la URL, si está presente.
$id = isset($_GET['id']) ? $_GET['id'] : null;

// Se selecciona la acción a realizar en función del método HTTP.
switch ($method) {
    case 'GET':
        if ($id) {
            // Obtener una tarea por su ID.
            $task = $taskService->getTaskById($id);
            echo json_encode($task);
        } else {
            // Obtener todas las tareas.
            $tasks = $taskService->getTasks();
            echo json_encode($tasks);
        }
        break;
    
    case 'POST':
        // Crear una nueva tarea.
        if (isset($input['title']) && isset($input['description'])) {
            $taskService->saveTask($input['title'], $input['description']);
            echo json_encode(["message" => "Task Created Successfully"]);
        } else {
            echo json_encode(["error" => "Invalid Input"]);
        }
        break;

    case 'PUT':
        // Actualizar una tarea existente.
        if ($id && isset($input['title']) && isset($input['description'])) {
            $taskService->updateTask($id, $input['title'], $input['description']);
            echo json_encode(["message" => "Task Updated Successfully"]);
        } else {
            echo json_encode(["error" => "Invalid Input"]);
        }
        break;

    case 'DELETE':
        // Eliminar una tarea por su ID.
        if ($id) {
            $taskService->deleteTask($id);
            echo json_encode(["message" => "Task Deleted Successfully"]);
        } else {
            echo json_encode(["error" => "Invalid ID"]);
        }
        break;

    default:
        // Respuesta para métodos HTTP no soportados.
        echo json_encode(["error" => "Method Not Supported"]);
        break;
}
?>
