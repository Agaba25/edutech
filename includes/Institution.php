<?php
/**
 * Institution Model Class
 */

class Institution {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    // Get all institutions
    public function getAll($limit = null, $offset = 0) {
        $query = 'SELECT * FROM institutions ORDER BY name ASC';
        if ($limit) {
            $query .= ' LIMIT ? OFFSET ?';
            return $this->db->fetchAll($query, [$limit, $offset]);
        }
        return $this->db->fetchAll($query);
    }

    // Get institution by ID
    public function getById($id) {
        return $this->db->fetchOne(
            'SELECT * FROM institutions WHERE id = ?',
            [$id]
        );
    }

    // Search institutions
    public function search($keyword, $region = null, $limit = null, $offset = 0) {
        $query = 'SELECT * FROM institutions WHERE name LIKE ? OR short_description LIKE ?';
        $params = ['%' . $keyword . '%', '%' . $keyword . '%'];

        if ($region) {
            $query .= ' AND region = ?';
            $params[] = $region;
        }

        $query .= ' ORDER BY name ASC';
        
        if ($limit) {
            $query .= ' LIMIT ? OFFSET ?';
            $params[] = $limit;
            $params[] = $offset;
        }
        
        return $this->db->fetchAll($query, $params);
    }

    // Get institutions by region
    public function getByRegion($region, $limit = null, $offset = 0) {
        $query = 'SELECT * FROM institutions WHERE region = ? ORDER BY name ASC';
        $params = [$region];
        
        if ($limit) {
            $query .= ' LIMIT ? OFFSET ?';
            $params[] = $limit;
            $params[] = $offset;
        }
        
        return $this->db->fetchAll($query, $params);
    }

    // Get all regions
    public function getAllRegions() {
        $results = $this->db->fetchAll(
            'SELECT DISTINCT region FROM institutions WHERE region IS NOT NULL ORDER BY region ASC'
        );
        return array_column($results, 'region');
    }

    // Create institution
    public function create($data) {
        $query = 'INSERT INTO institutions (name, short_name, short_description, address, region, logo_path, contact_email, phone, website)
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)';

        $stmt = $this->db->execute($query, [
            $data['name'],
            $data['short_name'] ?? null,
            $data['short_description'] ?? null,
            $data['address'] ?? null,
            $data['region'] ?? null,
            $data['logo_path'] ?? null,
            $data['contact_email'] ?? null,
            $data['phone'] ?? null,
            $data['website'] ?? null,
        ]);

        return $stmt ? $this->db->lastInsertId() : false;
    }

    // Update institution
    public function update($id, $data) {
        $query = 'UPDATE institutions SET name = ?, short_name = ?, short_description = ?, address = ?, region = ?,
                  logo_path = ?, contact_email = ?, phone = ?, website = ? WHERE id = ?';

        $stmt = $this->db->execute($query, [
            $data['name'],
            $data['short_name'] ?? null,
            $data['short_description'] ?? null,
            $data['address'] ?? null,
            $data['region'] ?? null,
            $data['logo_path'] ?? null,
            $data['contact_email'] ?? null,
            $data['phone'] ?? null,
            $data['website'] ?? null,
            $id,
        ]);

        return (bool) $stmt;
    }

    // Delete institution
    public function delete($id) {
        $stmt = $this->db->execute('DELETE FROM institutions WHERE id = ?', [$id]);
        return (bool) $stmt;
    }
}
?>
