<?php
/**
 * Program Model Class (tables: programs, subject_combinations)
 */

class Program {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getAll() {
        return $this->db->fetchAll(
            'SELECT p.*, i.name AS institution_name FROM programs p
             INNER JOIN institutions i ON p.institution_id = i.id
             ORDER BY p.name ASC'
        );
    }

    public function getById($id) {
        return $this->db->fetchOne(
            'SELECT * FROM programs WHERE id = ?',
            [$id]
        );
    }

    /**
     * Program row joined with owning institution (detail pages).
     */
    public function getByIdWithInstitution($id) {
        return $this->db->fetchOne(
            'SELECT p.*, i.name AS institution_name, i.short_name AS institution_short_name,
                    i.website, i.contact_email, i.phone, i.region, i.address
             FROM programs p
             INNER JOIN institutions i ON p.institution_id = i.id
             WHERE p.id = ?',
            [$id]
        );
    }

    public function getSubjectCombinations($program_id) {
        return $this->db->fetchAll(
            'SELECT * FROM subject_combinations WHERE program_id = ? ORDER BY combination_code ASC',
            [$program_id]
        );
    }

    public function getByInstitution($institution_id) {
        return $this->db->fetchAll(
            'SELECT p.*, i.name AS institution_name FROM programs p
             INNER JOIN institutions i ON p.institution_id = i.id
             WHERE p.institution_id = ?
             ORDER BY p.level, p.name ASC',
            [$institution_id]
        );
    }

    public function getByLevel($level, $limit = null, $offset = 0) {
        $query = 'SELECT p.*, i.name AS institution_name FROM programs p
                  INNER JOIN institutions i ON p.institution_id = i.id
                  WHERE p.level = ? ORDER BY p.name ASC';
        $params = [$level];

        if ($limit !== null && $limit !== '') {
            $query .= ' LIMIT ? OFFSET ?';
            $params[] = (int) $limit;
            $params[] = (int) $offset;
        }

        return $this->db->fetchAll($query, $params);
    }

    public function search($keyword, $limit = null, $offset = 0) {
        $query = 'SELECT p.*, i.name AS institution_name FROM programs p
                  INNER JOIN institutions i ON p.institution_id = i.id
                  WHERE p.name LIKE ? OR p.description LIKE ?
                  ORDER BY p.name ASC';
        $params = ['%' . $keyword . '%', '%' . $keyword . '%'];

        if ($limit !== null && $limit !== '') {
            $query .= ' LIMIT ? OFFSET ?';
            $params[] = (int) $limit;
            $params[] = (int) $offset;
        }

        return $this->db->fetchAll($query, $params);
    }

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
            $data['description'] ?? null,
        ]);

        return $stmt ? $this->db->lastInsertId() : false;
    }

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
            $id,
        ]);

        return (bool) $stmt;
    }

    public function delete($id) {
        $stmt = $this->db->execute('DELETE FROM programs WHERE id = ?', [$id]);
        return (bool) $stmt;
    }
}

