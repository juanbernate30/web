<?php
include_once("controlador/task_service.php");
include("includes/header.php");

// Crear una instancia del servicio
$taskService = new TaskService();

// Obtener las tareas
$tasks = $taskService->getTasks();

// Comenzar el buffer de salida
ob_start();

// Incluir la vista HTML
include("templates/index.html");

// Obtener el contenido del buffer
$html = ob_get_clean();

// Generar el HTML de las tareas
$taskHtml = '';
foreach ($tasks as $task) {
    $taskHtml .= "
        <tr>
            <td>{$task['title']}</td>
            <td>{$task['description']}</td>
            <td>{$task['created_at']}</td>
            <td>
                <a href='edit_task.php?id={$task['id']}' class='btn btn-secondary'>
                    <i class='fa fa-edit'></i>
                </a>
                <a href='delete_task.php?id={$task['id']}' class='btn btn-danger'>
                    <i class='fa fa-trash'></i>
                </a>
            </td>
        </tr>";
}

// Reemplazar el placeholder {{tasks}} en el HTML con el contenido dinámico generado
$html = str_replace("{{tasks}}", $taskHtml, $html);

// Imprimir el HTML resultante
echo $html;

include("includes/footer.php");
?>
