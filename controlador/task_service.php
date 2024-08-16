<?php
// Incluye el archivo de conexión a la base de datos
include_once('controlador/conexion.php'); 

/**
 * Clase para manejar las operaciones de tareas en la base de datos.
 */
class TaskService {
    private $pdo;

    /**
     * Constructor de la clase.
     * Inicializa la conexión PDO usando la clase Coneccion.
     */
    public function __construct() {
        $this->pdo = Coneccion::getInstance()->getPdo();
    }

    /**
     * Obtiene todas las tareas.
     * 
     * @return array Array de tareas, cada una representada como un array asociativo.
     */
    public function getTasks() {
        $stmt = $this->pdo->query("SELECT * FROM task"); 
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtiene una tarea específica por su ID.
     * 
     * @param int $id ID de la tarea a obtener.
     * @return array|null Datos de la tarea si se encuentra, null en caso contrario.
     */
    public function getTaskById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM task WHERE ID = :id"); 
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Guarda una nueva tarea en la base de datos.
     * 
     * @param string $title Título de la tarea.
     * @param string $description Descripción de la tarea.
     * @return bool Devuelve true si la tarea se guardó correctamente, false en caso contrario.
     */
    public function saveTask($title, $description) {
        try {
            // Preparar la consulta SQL
            $stmt = $this->pdo->prepare("INSERT INTO task (title, description, created_at) VALUES (:title, :description, NOW())");
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':description', $description);

            // Ejecutar la consulta
            return $stmt->execute();
        } catch (PDOException $e) {
            // Manejo de errores
            error_log("Database error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Actualiza una tarea existente en la base de datos.
     * 
     * @param int $id ID de la tarea a actualizar.
     * @param string $title Nuevo título de la tarea.
     * @param string $description Nueva descripción de la tarea.
     * @return void
     */
    public function updateTask($id, $title, $description) {
        $stmt = $this->pdo->prepare("UPDATE task SET title = :title, description = :description WHERE ID = :id");
        $stmt->execute(['id' => $id, 'title' => $title, 'description' => $description]);
    }

    /**
     * Elimina una tarea de la base de datos.
     * 
     * @param int $id ID de la tarea a eliminar.
     * @return void
     */
    public function deleteTask($id) {
        $stmt = $this->pdo->prepare("DELETE FROM task WHERE ID = :id");
        $stmt->execute(['id' => $id]);
    }
}
?>
