<?php
// Incluye el archivo que contiene la clase TaskService para manejar las operaciones relacionadas con las tareas.
include_once("controlador/task_service.php");

// Incluye el archivo de cabecera que contiene la estructura común de la página (por ejemplo, la barra de navegación, etc.).
include("includes/header.php");

// Crear una instancia del servicio de tareas para interactuar con las operaciones de la base de datos.
$taskService = new TaskService();

// Obtener todas las tareas almacenadas en la base de datos utilizando el servicio de tareas.
$tasks = $taskService->getTasks();

// Comenzar el buffer de salida para capturar el contenido de la vista HTML antes de imprimirlo.
ob_start();

// Incluir la vista HTML principal (index.html) que contiene la estructura de la tabla donde se mostrarán las tareas.
include("templates/index.html");

// Obtener el contenido almacenado en el buffer y asignarlo a una variable.
$html = ob_get_clean();

// Generar el HTML dinámico para cada tarea obtenida de la base de datos.
$taskHtml = '';
foreach ($tasks as $task) {
    // Por cada tarea, se genera una fila de la tabla con los datos de la tarea (título, descripción, fecha de creación)
    // y los botones para editar y eliminar la tarea.
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

// Reemplazar el placeholder {{tasks}} en el HTML con el contenido dinámico generado en la variable $taskHtml.
$html = str_replace("{{tasks}}", $taskHtml, $html);

// Imprimir el HTML resultante, que incluye la tabla de tareas con los datos generados dinámicamente.
echo $html;

// Incluye el archivo de pie de página que contiene la estructura común de la parte inferior de la página.
include("includes/footer.php");
?>
