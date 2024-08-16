<?php
// Se declara la clase principal para manejar la conección a la base de datos.
class Coneccion
{
    // Instancia única de la clase (patrón Singleton).
    private static $instance = null;

    // Instancia de PDO para manejar la conección a la base de datos.
    private $pdo;

    // Constructor privado para establecer la conección a la base de datos PostgreSQL.
    private function __construct()
    {
        $host = "localhost";
        $dbname = "php_crud";
        $username = "postgres";
        $password = "Juan1927*";

        // Se establece la conección a la base de datos PostgreSQL y se configura PDO.
        try {
            $this->pdo = new PDO("pgsql:host=$host;dbname=$dbname", $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exp) {
            // Se maneja cualquier error que ocurra durante la conexión.
            echo "No se pudo conectar a la base de datos: " . $exp->getMessage();
            exit;
        }
    }


    /**
     * Obtiene la instancia única de la clase (patrón Singleton).
     *
     * Si la instancia aún no ha sido creada, la crea y la retorna.
     * Si la instancia ya existe, simplemente la retorna.
     *
     * @return self La instancia única de la clase.
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }


    /**
     * Retorna la instancia de PDO asociada con la clase.
     *
     * @return PDO La instancia de PDO.
     */
    public function getPdo()
    {
        return $this->pdo;
    }

    /**
     * Previene la clonación de la instancia (patrón Singleton).
     *
     * Este método está vacío para garantizar que no se pueda clonar la instancia.
     */
    private function __clone() {}


    /**
     * Previene la deserialización de la instancia (patrón Singleton).
     *
     * Este método está vacío para garantizar que la instancia no pueda ser deserializada.
     */
    public function __wakeup() {}
}
