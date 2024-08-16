<?php
class Coneccion {
    private static $instance = null;
    private $pdo;

    private function __construct() {
        $host = "localhost";
        $dbname = "php_crud";
        $username = "postgres";
        $password = "Juan1927*";

        try {
            $this->pdo = new PDO("pgsql:host=$host;dbname=$dbname", $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exp) {
            echo "No se pudo conectar a la base de datos: " . $exp->getMessage();
            exit;
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getPdo() {
        return $this->pdo;
    }

    private function __clone() {}

    public function __wakeup() {}
}
?>
