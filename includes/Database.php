<?php
/**
 * Database access via PDO (shared hosting friendly).
 */

class Database {
    private $pdo;
    private static $instance = null;
    /** @var PDOStatement|null */
    private $lastStatement = null;

    private function __construct() {
        $port = defined('DB_PORT') ? DB_PORT : '3306';
        $dsn = sprintf(
            'mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4',
            DB_HOST,
            $port,
            DB_NAME
        );
        $opts = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        try {
            $this->pdo = new PDO($dsn, DB_USER, DB_PASS, $opts);
        } catch (PDOException $e) {
            error_log('Database connection failed: ' . $e->getMessage());
            if (class_exists('Config') && Config::isDevelopment()) {
                die('Database connection failed: ' . htmlspecialchars($e->getMessage()));
            }
            die('Database connection failed. Please try again later.');
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __clone() {}

    /** @return PDO */
    public function getConnection() {
        return $this->pdo;
    }

    /**
     * @param string $query
     * @param array $params
     * @return PDOStatement|false
     */
    public function execute($query, $params = []) {
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute($params);
            $this->lastStatement = $stmt;
            return $stmt;
        } catch (PDOException $e) {
            error_log('Database Error: ' . $e->getMessage());
            $this->lastStatement = null;
            return false;
        }
    }

    public function fetchOne($query, $params = []) {
        $stmt = $this->execute($query, $params);
        if (!$stmt) {
            return null;
        }
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function fetchAll($query, $params = []) {
        $stmt = $this->execute($query, $params);
        if (!$stmt) {
            return [];
        }
        return $stmt->fetchAll();
    }

    public function lastInsertId() {
        return $this->pdo->lastInsertId();
    }

    public function affectedRows() {
        return $this->lastStatement ? $this->lastStatement->rowCount() : 0;
    }

    public function close() {
        $this->pdo = null;
        self::$instance = null;
    }
}
