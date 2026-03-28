<?php
/**
 * Program Model Class
 */

class Program {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    // Get all programs
    public function getAll() {
        return $this->db->fetchAll('SELECT * FROM programs ORDER BY name ASC');
    }

    // Get program by ID
    public function getById($id) {
        return $this->db->fetchOne(
            'SELECT * FROM programs WHERE id = ?',
            [$id]
        );
    }

    // Get programs by institution
    public function getByInstitution($institution_id) {
        return $this->db->fetchAll(
            'SELECT * FROM programs WHERE institution_id = ? ORDER BY level, name ASC',
            [$institution_id]
        );
    }

    // Get programs by level
    public function getByLevel($level, $limit = null, $offset = 0) {
        $query = 'SELECT p.*, i.name as institution_name FROM programs p 
                  JOIN institutions i ON p.institution_id = i.id 
                  WHERE p.level = ? ORDER BY p.name ASC';
        $params = [$level];
        
        if ($limit) {
            $query .= ' LIMIT ? OFFSET ?';
            $params[] = $limit;
            $params[] = $offset;
        }
        
        return $this->db->fetchAll($query, $params);
    }

    // Search programs
    public function search($keyword, $limit = null, $offset = 0) {
        $query = 'SELECT p.*, i.name as institution_name FROM programs p 
                  JOIN institutions i ON p.institution_id = i.id 
                  WHERE p.name LIKE ? OR p.description LIKE ? 
                  ORDER BY p.name ASC';
        $params = ['%' . $keyword . '%', '%' . $keyword . '%'];
        
        if ($limit) {
            $query .= ' LIMIT ? OFFSET ?';
            $params[] = $limit;
            $params[] = $offset;
        }
        
        return $this->db->fetchAll($query, $params);
    }

    // Create program
    public function create($data) {
        $query = 'INSERT INTO programs (institution_id, level, name, duration, fee_estimate, cutoff_info, description) 
                  VALUES (?, ?, ?, ?, ?, ?, ?)';
        
        $stmt = $this->db->execute($query, [
            $data['institution_id'],
            $data['level'],
            $data['name'],
            $data['duration'] ?? null,
            $data['fee_estimate'] ?? null,
            $data['cutoff_info'] ?? null,
            $data['description'] ?? null
        ]);

        return $stmt ? $this->db->lastInsertId() : false;
    }

    // Update program
    public function update($id, $data) {
        $query = 'UPDATE programs SET institution_id = ?, level = ?, name = ?, duration = ?, 
                  fee_estimate = ?, cutoff_info = ?, description = ? WHERE id = ?';
        
        $stmt = $this->db->execute($query, [
            $data['institution_id'],
            $data['level'],
            $data['name'],
            $data['duration'] ?? null,
            $data['fee_estimate'] ?? null,
            $data['cutoff_info'] ?? null,
            $data['description'] ?? null,
            $id
        ]);

        return $stmt ? true : false;
    }

    // Delete program
    public function delete($id) {
        $stmt = $this->db->execute('DELETE FROM programs WHERE id = ?', [$id]);
        return $stmt ? true : false;
    }
}
?>
