<?php
/**
 * Database Connection Class
 * Handles all database operations with prepared statements
 */

class Database {
    private $connection;
    private static $instance = null;

    private function __construct() {
        try {
            $this->connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            
            if ($this->connection->connect_error) {
                throw new Exception('Database connection failed: ' . $this->connection->connect_error);
            }
            
            $this->connection->set_charset('utf8mb4');
        } catch (Exception $e) {
            die('Connection Error: ' . $e->getMessage());
        }
    }

    // Singleton pattern to prevent multiple connections
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    // Prevent cloning
    private function __clone() {}

    // Get connection
    public function getConnection() {
        return $this->connection;
    }

    // Execute prepared statement
    public function execute($query, $params = [], $types = '') {
        try {
            $stmt = $this->connection->prepare($query);
            
            if (!$stmt) {
                throw new Exception('Prepare failed: ' . $this->connection->error);
            }
            
            if (!empty($params)) {
                if (empty($types)) {
                    // Auto-detect types
                    $types = '';
                    foreach ($params as $param) {
                        if (is_int($param)) {
                            $types .= 'i';
                        } elseif (is_float($param)) {
                            $types .= 'd';
                        } else {
                            $types .= 's';
                        }
                    }
                }
                $stmt->bind_param($types, ...$params);
            }
            
            if (!$stmt->execute()) {
                throw new Exception('Execute failed: ' . $stmt->error);
            }
            
            return $stmt;
        } catch (Exception $e) {
            error_log('Database Error: ' . $e->getMessage());
            return false;
        }
    }

    // Fetch single row
    public function fetchOne($query, $params = []) {
        $stmt = $this->execute($query, $params);
        if (!$stmt) return null;
        
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();
        
        return $row;
    }

    // Fetch all rows
    public function fetchAll($query, $params = []) {
        $stmt = $this->execute($query, $params);
        if (!$stmt) return [];
        
        $result = $stmt->get_result();
        $rows = [];
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        $stmt->close();
        
        return $rows;
    }

    // Get last insert ID
    public function lastInsertId() {
        return $this->connection->insert_id;
    }

    // Get affected rows
    public function affectedRows() {
        return $this->connection->affected_rows;
    }

    // Close connection
    public function close() {
        if ($this->connection) {
            $this->connection->close();
        }
    }
}
?>
