<?php
include_once('controlador/conexion.php'); // Verifica que la ruta y el nombre del archivo sean correctos

class TaskService {
    private $pdo;

    public function __construct() {
        $this->pdo = Coneccion::getInstance()->getPdo();
    }

    public function getTasks() {
        $stmt = $this->pdo->query("SELECT * FROM task"); // Usa 'task' aquí
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTaskById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM task WHERE ID = :id"); // Usa 'task' aquí
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function saveTask($title, $description) {
        $stmt = $this->pdo->prepare("INSERT INTO task (title, description) VALUES (:title, :description)"); // Usa 'task' aquí
        $stmt->execute(['title' => $title, 'description' => $description]);
    }

    public function updateTask($id, $title, $description) {
        $stmt = $this->pdo->prepare("UPDATE task SET title = :title, description = :description WHERE ID = :id"); // Usa 'task' aquí
        $stmt->execute(['id' => $id, 'title' => $title, 'description' => $description]);
    }

    public function deleteTask($id) {
        $stmt = $this->pdo->prepare("DELETE FROM task WHERE ID = :id"); // Usa 'task' aquí
        $stmt->execute(['id' => $id]);
    }
}
?>
